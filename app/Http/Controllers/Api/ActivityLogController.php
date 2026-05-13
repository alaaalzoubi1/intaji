<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Activity\StoreActivityLogRequest;
use App\Http\Requests\Activity\UpdateActivityLogRequest;
use App\Http\Resources\ActivityLogResource;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\ProductivityTree;
use App\Models\UserPoints;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityLogController extends ApiController
{
    // GET /api/logs?date=2026-05-12&activity_id=1  (FR-08)
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'date'        => 'sometimes|date',
            'from'        => 'sometimes|date',
            'to'          => 'sometimes|date',
            'activity_id' => 'sometimes|exists:activities,id',
            'section_id'  => 'sometimes|exists:sections,id',
        ]);

        $query = ActivityLog::where('user_id', $request->user()->id)
            ->with('activity.section')
            ->orderByDesc('log_date');

        if ($request->date)        $query->whereDate('log_date', $request->date);
        if ($request->from)        $query->whereDate('log_date', '>=', $request->from);
        if ($request->to)          $query->whereDate('log_date', '<=', $request->to);
        if ($request->activity_id) $query->where('activity_id', $request->activity_id);
        if ($request->section_id) {
            $query->whereHas('activity', fn($q) => $q->where('section_id', $request->section_id));
        }

        return $this->success(ActivityLogResource::collection($query->paginate(50)));
    }

    // POST /api/logs  (FR-06)
    public function store(StoreActivityLogRequest $request): JsonResponse
    {
        $user     = $request->user();
        $activity = Activity::findOrFail($request->activity_id);

        // تحقق من عدم التسجيل المكرر لنفس اليوم
        $exists = ActivityLog::where([
            'user_id'     => $user->id,
            'activity_id' => $activity->id,
            'log_date'    => $request->log_date ?? today()->toDateString(),
        ])->exists();

        if ($exists) {
            return $this->error('تم تسجيل هذا النشاط مسبقاً لهذا اليوم. استخدم التعديل بدلاً من ذلك.', 409);
        }

        $log = ActivityLog::create([
            'user_id'             => $user->id,
            'activity_id'         => $activity->id,
            'log_date'            => $request->log_date ?? today()->toDateString(),
            'value_bool'          => $request->value_bool,
            'value_numeric'       => $request->value_numeric,
            'value_rating'        => $request->value_rating,
            'value_text'          => $request->value_text,
            'value_seconds'       => $request->value_seconds,
            'input_method'        => $request->input_method ?? 'manual',
            'failure_reason'      => $request->failure_reason,
            'failure_reason_note' => $request->failure_reason_note,
            'note'                => $request->note,
            'evidence_image'      => $request->hasFile('evidence_image')
                                        ? $request->file('evidence_image')->store('evidence', 'public')
                                        : null,
        ]);

        // إضافة النقاط إذا كان النشاط منجزاً  (FR-28)
        if ($log->isCompleted()) {
            $points = UserPoints::firstOrCreate(['user_id' => $user->id]);
            $points->addPoints($activity->points, 'activity_completed', $log);

            // سقي الشجرة  (FR-30)
            $tree = ProductivityTree::firstOrCreate(['user_id' => $user->id]);
            $tree->water();
        }

        return $this->created(new ActivityLogResource($log->load('activity.section')));
    }

    // GET /api/logs/{log}
    public function show(Request $request, ActivityLog $log): JsonResponse
    {
        $this->authorizeLog($request, $log);
        return $this->success(new ActivityLogResource($log->load('activity.section')));
    }

    // PUT /api/logs/{log}  (FR-07)
    public function update(UpdateActivityLogRequest $request, ActivityLog $log): JsonResponse
    {
        $this->authorizeLog($request, $log);

        // حفظ تاريخ التعديل
        $history   = $log->edit_history ?? [];
        $history[] = [
            'edited_at' => now()->toDateTimeString(),
            'old_values' => [
                'value_bool'    => $log->value_bool,
                'value_numeric' => $log->value_numeric,
                'value_rating'  => $log->value_rating,
                'value_text'    => $log->value_text,
            ],
        ];

        $log->update(array_merge(
            $request->validated(),
            ['edited_at' => now(), 'edit_history' => $history]
        ));

        return $this->success(new ActivityLogResource($log->fresh()->load('activity.section')), 'تم تحديث التسجيل');
    }

    // DELETE /api/logs/{log}  (FR-07)
    public function destroy(Request $request, ActivityLog $log): JsonResponse
    {
        $this->authorizeLog($request, $log);
        $log->delete();
        return $this->success(message: 'تم حذف التسجيل');
    }

    // GET /api/logs/calendar?month=2026-05  (FR-08)
    public function calendar(Request $request): JsonResponse
    {
        $request->validate(['month' => 'required|date_format:Y-m']);

        [$year, $month] = explode('-', $request->month);

        $logs = ActivityLog::where('user_id', $request->user()->id)
            ->whereYear('log_date', $year)
            ->whereMonth('log_date', $month)
            ->with('activity:id,name,section_id,points,measurement_type')
            ->get()
            ->groupBy(fn($log) => $log->log_date->toDateString());

        return $this->success($logs);
    }

    private function authorizeLog(Request $request, ActivityLog $log): void
    {
        abort_if($log->user_id !== $request->user()->id, 403, 'غير مصرح');
    }
}
