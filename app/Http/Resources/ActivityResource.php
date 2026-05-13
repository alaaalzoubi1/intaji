<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request): array
    {
        $userSetting = $this->userSettings->first();
        $todayLog    = $this->logs->first();

        return [
            'id'               => $this->id,
            'section_id'       => $this->section_id,
            'section'          => $this->whenLoaded('section', fn() => [
                'id'    => $this->section->id,
                'name'  => $this->section->name,
                'color' => $this->section->color,
            ]),
            'name'             => $this->name,
            'description'      => $this->description,
            'icon'             => $this->icon,
            'measurement_type' => $this->measurement_type,
            'unit'             => $this->unit,
            'points'           => $this->points,
            'repeat_type'      => $this->repeat_type,
            'specific_days'    => $this->specific_days,
            'user_settings'    => $userSetting ? [
                'is_enabled'            => $userSetting->is_enabled,
                'reminder_time'         => $userSetting->reminder_time,
                'smart_reminder'        => $userSetting->smart_reminder,
                'notifications_enabled' => $userSetting->notifications_enabled,
            ] : [
                'is_enabled'            => true,
                'reminder_time'         => $this->default_reminder_time,
                'smart_reminder'        => false,
                'notifications_enabled' => true,
            ],
            'today_log' => $todayLog ? new ActivityLogResource($todayLog) : null,
        ];
    }
}
