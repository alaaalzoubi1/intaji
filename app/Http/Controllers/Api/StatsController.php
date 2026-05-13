<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\AppUsageLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends ApiController
{
    // GET /api/stats/overview  (FR-23) — Dashboard الرئيسي
    public function overview(Request $request): JsonResponse
    {
        $user  = $request->user();
        $today = today();
        $weekStart = $today->copy()->startOfWeek();

        // نسبة الإنتاج اليومية
        $todayLogs       = ActivityLog::where('user_id', $user->id)->whereDate('log_date', $today)->get();
        $todayActivities = Activity::active()->get()->filter(fn($a) => $a->isScheduledForDay($today->dayOfWeek));

        $dailyRate = $todayActivities->count() > 0
            ? round($todayLogs->count() / $todayActivities->count() * 100)
            : 0;

        // نقاط الأسبوع
        $weeklyPoints = DB::table('point_transactions')
            ->where('user_id', $user->id)
            ->where('amount', '>', 0)
            ->whereBetween('created_at', [$weekStart, $today->copy()->endOfDay()])
            ->sum('amount');

        // استهلاك التطبيقات اليوم
        $appUsageToday = AppUsageLog::where('user_id', $user->id)
            ->whereDate('usage_date', $today)
            ->sum('duration_minutes');

        $tree   = $user->productivityTree;
        $points = $user->points;

        return $this->success([
            'daily_completion_rate' => $dailyRate,
            'today_logged'          => $todayLogs->count(),
            'today_total'           => $todayActivities->count(),
            'weekly_points'         => $weeklyPoints,
            'total_points'          => $points?->total_points ?? 0,
            'available_points'      => $points?->available_points ?? 0,
            'app_usage_today_mins'  => $appUsageToday,
            'tree' => $tree ? [
                'health' => $tree->health,
                'level'  => $tree->level,
                'state'  => $tree->tree_state,
            ] : null,
        ]);
    }

    // GET /api/stats/activity/{activity}?period=week|month|year  (FR-19)
    public function activityStats(Request $request, Activity $activity): JsonResponse
    {
        $request->validate(['period' => 'in:week,month,year']);
        $period = $request->period ?? 'month';

        $from = match ($period) {
            'week'  => now()->subDays(7),
            'month' => now()->subDays(30),
            'year'  => now()->subDays(365),
        };

        $logs = ActivityLog::where('user_id', $request->user()->id)
            ->where('activity_id', $activity->id)
            ->whereDate('log_date', '>=', $from)
            ->orderBy('log_date')
            ->get();

        $total       = $logs->count();
        $completed   = $logs->filter(fn($l) => $l->isCompleted())->count();
        $commitment  = $total > 0 ? round($completed / $total * 100) : 0;

        // بيانات الرسم البياني يومياً (FR-20)
        $chartData = $logs->groupBy(fn($l) => $l->log_date->toDateString())
            ->map(fn($dayLogs) => [
                'date'      => $dayLogs->first()->log_date->toDateString(),
                'completed' => $dayLogs->filter(fn($l) => $l->isCompleted())->count(),
                'value'     => $dayLogs->avg('value_numeric'),
            ])->values();

        return $this->success([
            'activity'        => ['id' => $activity->id, 'name' => $activity->name],
            'period'          => $period,
            'total_logs'      => $total,
            'completed'       => $completed,
            'commitment_rate' => $commitment,
            'chart_data'      => $chartData,
        ]);
    }

    // GET /api/stats/compare?period_a=2026-04&period_b=2026-05  (FR-21)
    public function compare(Request $request): JsonResponse
    {
        $request->validate([
            'period_a' => 'required|date_format:Y-m',
            'period_b' => 'required|date_format:Y-m',
        ]);

        $userId = $request->user()->id;

        $statsFor = function (string $yearMonth) use ($userId) {
            [$year, $month] = explode('-', $yearMonth);
            $logs = ActivityLog::where('user_id', $userId)
                ->whereYear('log_date', $year)
                ->whereMonth('log_date', $month)
                ->with('activity:id,points')
                ->get();

            return [
                'period'          => $yearMonth,
                'total_logs'      => $logs->count(),
                'completed'       => $logs->filter(fn($l) => $l->isCompleted())->count(),
                'total_points'    => $logs->filter(fn($l) => $l->isCompleted())->sum(fn($l) => $l->activity->points ?? 0),
                'commitment_rate' => $logs->count() > 0
                    ? round($logs->filter(fn($l) => $l->isCompleted())->count() / $logs->count() * 100)
                    : 0,
            ];
        };

        return $this->success([
            'period_a' => $statsFor($request->period_a),
            'period_b' => $statsFor($request->period_b),
        ]);
    }

    // GET /api/stats/sections  — أداء كل الأقسام (FR-23)
    public function sectionStats(Request $request): JsonResponse
    {
        $request->validate(['from' => 'date', 'to' => 'date']);
        $from = $request->from ?? now()->subDays(30)->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $stats = DB::table('activity_logs as al')
            ->join('activities as a', 'al.activity_id', '=', 'a.id')
            ->join('sections as s', 'a.section_id', '=', 's.id')
            ->where('al.user_id', $request->user()->id)
            ->whereBetween('al.log_date', [$from, $to])
            ->select(
                's.id as section_id',
                's.name as section_name',
                's.color',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN al.value_bool = 1 OR al.value_numeric IS NOT NULL THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(a.points) as total_points')
            )
            ->groupBy('s.id', 's.name', 's.color')
            ->get()
            ->map(function ($row) {
                $row->commitment_rate = $row->total > 0 ? round($row->completed / $row->total * 100) : 0;
                return $row;
            });

        return $this->success($stats);
    }

    // GET /api/stats/correlations  (FR-22) — إحصائيات مركبة
    public function correlations(Request $request): JsonResponse
    {
        $request->validate([
            'activity_a' => 'required|exists:activities,id',
            'activity_b' => 'required|exists:activities,id',
        ]);

        $userId = $request->user()->id;

        // أيام نُجز فيها النشاط A، ما هو متوسط أداء B؟
        $daysA = ActivityLog::where('user_id', $userId)
            ->where('activity_id', $request->activity_a)
            ->where(fn($q) => $q->where('value_bool', true)->orWhereNotNull('value_numeric'))
            ->pluck('log_date');

        $avgBonDaysA = ActivityLog::where('user_id', $userId)
            ->where('activity_id', $request->activity_b)
            ->whereIn('log_date', $daysA)
            ->avg('value_numeric') ?? 0;

        $avgBonAllDays = ActivityLog::where('user_id', $userId)
            ->where('activity_id', $request->activity_b)
            ->avg('value_numeric') ?? 0;

        return $this->success([
            'activity_a_done_days'  => $daysA->count(),
            'avg_b_when_a_done'     => round($avgBonDaysA, 2),
            'avg_b_overall'         => round($avgBonAllDays, 2),
            'correlation_note'      => $avgBonDaysA > $avgBonAllDays
                ? 'أداؤك في النشاط B يرتفع في أيام إنجاز A'
                : 'لا يوجد ارتباط واضح بين النشاطين',
        ]);
    }
}
