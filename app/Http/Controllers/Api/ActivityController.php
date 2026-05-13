<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Activity\UpdateActivitySettingRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\SectionResource;
use App\Models\Activity;
use App\Models\Section;
use App\Models\UserActivitySetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends ApiController
{
    // GET /api/sections
    public function sections(Request $request): JsonResponse
    {
        $sections = Section::active()
            ->with(['activeActivities' => function ($q) use ($request) {
                $q->with(['userSettings' => fn($q) => $q->where('user_id', $request->user()->id)]);
            }])
            ->get();
        return $this->success(SectionResource::collection($sections));
    }

    // GET /api/sections/{section}/activities
    public function sectionActivities(Request $request, Section $section): JsonResponse
    {
        $activities = $section->activeActivities()
            ->with(['userSettings' => fn($q) => $q->where('user_id', $request->user()->id)])
            ->get();
        return $this->success(ActivityResource::collection($activities));
    }

    // GET /api/activities/today  (FR-09)
    public function todayActivities(Request $request): JsonResponse
    {
        $user      = $request->user();
        $dayOfWeek = now()->dayOfWeek;

        $activities = Activity::active()
            ->with([
                'section',
                'userSettings' => fn($q) => $q->where('user_id', $user->id),
                'logs'         => fn($q) => $q->where('user_id', $user->id)->whereDate('log_date', today()),
            ])
            ->get()
            ->filter(fn($a) => $a->isScheduledForDay($dayOfWeek))
            ->values();

        return $this->success(ActivityResource::collection($activities));
    }

    // PUT /api/activities/{activity}/settings  (FR-11)
    public function updateSettings(UpdateActivitySettingRequest $request, Activity $activity): JsonResponse
    {
        $setting = UserActivitySetting::updateOrCreate(
            ['user_id' => $request->user()->id, 'activity_id' => $activity->id],
            $request->validated()
        );
        return $this->success($setting, 'تم تحديث إعدادات النشاط');
    }
}
