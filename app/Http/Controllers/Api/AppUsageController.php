<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AppUsage\SetLimitRequest;
use App\Http\Requests\AppUsage\SyncAppUsageRequest;
use App\Models\AppUsageLimit;
use App\Models\AppUsageLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppUsageController extends ApiController
{
    // POST /api/app-usage/sync  (FR-14, FR-15) — الموبايل يرسل بيانات الاستخدام
    public function sync(SyncAppUsageRequest $request): JsonResponse
    {
        $user    = $request->user();
        $date    = $request->date ?? today()->toDateString();
        $synced  = 0;
        $warned  = [];

        foreach ($request->apps as $app) {
            AppUsageLog::updateOrCreate(
                [
                    'user_id'     => $user->id,
                    'app_package' => $app['package'],
                    'usage_date'  => $date,
                ],
                [
                    'app_name'         => $app['name'],
                    'app_category'     => $app['category'] ?? 'other',
                    'duration_minutes' => $app['minutes'],
                ]
            );
            $synced++;

            // تحقق من الحد المسموح (FR-17)
            $limit = AppUsageLimit::where('user_id', $user->id)
                ->where(fn($q) => $q->where('app_package', $app['package'])->orWhereNull('app_package'))
                ->orderByRaw("app_package IS NULL ASC") // تفضيل الحد المخصص على العام
                ->first();

            if ($limit && $app['minutes'] >= $limit->daily_limit_minutes) {
                $warned[] = [
                    'app'           => $app['name'],
                    'used_minutes'  => $app['minutes'],
                    'limit_minutes' => $limit->daily_limit_minutes,
                ];
            }
        }

        return $this->success([
            'synced' => $synced,
            'warnings' => $warned,
        ], 'تم مزامنة بيانات الاستخدام');
    }

    // GET /api/app-usage/report?period=today|week  (FR-15, FR-24)
    public function report(Request $request): JsonResponse
    {
        $request->validate(['period' => 'in:today,week,month']);
        $period = $request->period ?? 'week';

        $from = match ($period) {
            'today' => today()->toDateString(),
            'week'  => now()->subDays(7)->toDateString(),
            'month' => now()->subDays(30)->toDateString(),
        };

        $apps = AppUsageLog::where('user_id', $request->user()->id)
            ->whereDate('usage_date', '>=', $from)
            ->select('app_package', 'app_name', 'app_category', DB::raw('SUM(duration_minutes) as total_minutes'))
            ->groupBy('app_package', 'app_name', 'app_category')
            ->orderByDesc('total_minutes')
            ->get()
            ->map(fn($row) => [
                'package'       => $row->app_package,
                'name'          => $row->app_name,
                'category'      => $row->app_category,
                'total_minutes' => $row->total_minutes,
                'total_hours'   => round($row->total_minutes / 60, 1),
            ]);

        $totalEntertainment = $apps->where('category', 'entertainment')->sum('total_minutes')
                            + $apps->where('category', 'social')->sum('total_minutes')
                            + $apps->where('category', 'games')->sum('total_minutes');

        return $this->success([
            'period'                     => $period,
            'apps'                       => $apps,
            'total_entertainment_minutes'=> $totalEntertainment,
            'most_used'                  => $apps->first(),
        ]);
    }

    // GET /api/app-usage/correlation  (FR-16) — ربط الاستخدام بالأداء
    public function correlation(Request $request): JsonResponse
    {
        $request->validate([
            'app_package' => 'required|string',
            'activity_id' => 'required|exists:activities,id',
        ]);

        $userId = $request->user()->id;

        // جلب أيام بها بيانات للتطبيق
        $appDays = AppUsageLog::where('user_id', $userId)
            ->where('app_package', $request->app_package)
            ->get()
            ->keyBy(fn($r) => $r->usage_date->toDateString());

        if ($appDays->isEmpty()) {
            return $this->error('لا توجد بيانات كافية لهذا التطبيق');
        }

        // حساب معدل الأداء في الأيام ذات الاستخدام العالي vs المنخفض
        $threshold = $appDays->avg('duration_minutes'); // المتوسط كحد فاصل

        $highUsageDays = $appDays->filter(fn($r) => $r->duration_minutes > $threshold)->keys();
        $lowUsageDays  = $appDays->filter(fn($r) => $r->duration_minutes <= $threshold)->keys();

        $commitmentOn = fn($days) => \App\Models\ActivityLog::where('user_id', $userId)
            ->where('activity_id', $request->activity_id)
            ->whereIn('log_date', $days)
            ->where(fn($q) => $q->where('value_bool', true)->orWhereNotNull('value_numeric'))
            ->count();

        $highCount = $highUsageDays->count();
        $lowCount  = $lowUsageDays->count();

        $highRate = $highCount > 0 ? round($commitmentOn($highUsageDays) / $highCount * 100) : 0;
        $lowRate  = $lowCount  > 0 ? round($commitmentOn($lowUsageDays)  / $lowCount  * 100) : 0;

        return $this->success([
            'app_package'         => $request->app_package,
            'avg_usage_minutes'   => round($threshold),
            'high_usage_days'     => $highCount,
            'low_usage_days'      => $lowCount,
            'commitment_high_days'=> $highRate,
            'commitment_low_days' => $lowRate,
            'impact_percentage'   => $lowRate - $highRate,
            'insight'             => $highRate < $lowRate
                ? "في أيام الاستخدام العالي لهذا التطبيق، انخفض التزامك بالنشاط بنسبة " . ($lowRate - $highRate) . "%"
                : "لا يوجد تأثير واضح لهذا التطبيق على أداء النشاط",
        ]);
    }

    // POST /api/app-usage/limits  (FR-17)
    public function setLimit(SetLimitRequest $request): JsonResponse
    {
        $limit = AppUsageLimit::updateOrCreate(
            ['user_id' => $request->user()->id, 'app_package' => $request->app_package],
            ['daily_limit_minutes' => $request->daily_limit_minutes, 'is_active' => true]
        );

        return $this->success($limit, 'تم تحديد الحد اليومي');
    }

    // GET /api/app-usage/limits
    public function getLimits(Request $request): JsonResponse
    {
        $limits = AppUsageLimit::where('user_id', $request->user()->id)->get();
        return $this->success($limits);
    }
}
