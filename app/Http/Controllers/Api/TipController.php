<?php

namespace App\Http\Controllers\Api;

use App\Models\ActivityLog;
use App\Models\AppUsageLog;
use App\Models\Tip;
use App\Models\TipFeedback;
use App\Models\UserTipHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TipController extends ApiController
{
    // GET /api/tips/today  (FR-25, FR-27)
    public function today(Request $request): JsonResponse
    {
        $user  = $request->user();
        $today = today()->toDateString();

        // هل عُرضت نصيحة اليوم مسبقاً؟
        $existing = UserTipHistory::where('user_id', $user->id)
            ->whereDate('shown_date', $today)
            ->with('tip')
            ->first();

        if ($existing) {
            return $this->success([
                'tip'    => $existing->tip,
                'cached' => true,
            ]);
        }

        // بناء metrics للمستخدم لتقييم النصائح الشرطية
        $userMetrics = $this->buildUserMetrics($user->id);

        // نصيحة شرطية تنطبق أولاً، ثم ثابتة لم تُعرض من قبل
        $shownTipIds = UserTipHistory::where('user_id', $user->id)->pluck('tip_id');

        $tip = Tip::active()
            ->whereNotIn('id', $shownTipIds)
            ->get()
            ->first(fn($t) => $t->evaluateCondition($userMetrics));

        $tip ??= Tip::active()->where('type', 'static')->whereNotIn('id', $shownTipIds)->inRandomOrder()->first();
        $tip ??= Tip::active()->where('type', 'static')->inRandomOrder()->first(); // FR-27 fallback

        if ($tip) {
            UserTipHistory::create([
                'user_id'    => $user->id,
                'tip_id'     => $tip->id,
                'shown_date' => $today,
            ]);
        }

        return $this->success(['tip' => $tip, 'cached' => false]);
    }

    // GET /api/tips/history  — نصائح سابقة (FR-25)
    public function history(Request $request): JsonResponse
    {
        $history = UserTipHistory::where('user_id', $request->user()->id)
            ->with('tip')
            ->orderByDesc('shown_date')
            ->paginate(20);

        return $this->success($history);
    }

    // POST /api/tips/{tip}/feedback  (FR-26)
    public function feedback(Request $request, Tip $tip): JsonResponse
    {
        $request->validate(['is_helpful' => 'required|boolean']);

        TipFeedback::updateOrCreate(
            ['user_id' => $request->user()->id, 'tip_id' => $tip->id],
            ['is_helpful' => $request->is_helpful, 'shown_at' => now()]
        );

        return $this->success(message: 'شكراً على تقييمك');
    }

    private function buildUserMetrics(int $userId): array
    {
        $metrics = [];

        // معدل التزام الأسبوع الماضي لكل نشاط
        $weekLogs = ActivityLog::where('user_id', $userId)
            ->whereDate('log_date', '>=', now()->subDays(7))
            ->get()
            ->groupBy('activity_id');

        foreach ($weekLogs as $activityId => $logs) {
            $completed = $logs->filter(fn($l) => $l->isCompleted())->count();
            $metrics["activity_commitment_{$activityId}"] = $logs->count() > 0
                ? round($completed / $logs->count(), 2)
                : 0;
        }

        // وقت التطبيقات الترفيهية
        $entertainmentMins = AppUsageLog::where('user_id', $userId)
            ->whereDate('usage_date', today())
            ->whereIn('app_category', ['entertainment', 'social', 'games'])
            ->sum('duration_minutes');
        $metrics['entertainment_minutes'] = $entertainmentMins;

        return $metrics;
    }
}
