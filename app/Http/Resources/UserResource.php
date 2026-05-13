<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'phone'                 => $this->phone,
            'avatar'                => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'chronotype'            => $this->chronotype,
            'activity_preference'   => $this->activity_preference,
            'main_goals'            => $this->main_goals,
            'dark_mode'             => $this->dark_mode,
            'language'              => $this->language,
            'notifications_enabled' => $this->notifications_enabled,
            'app_tracking_enabled'  => $this->app_tracking_enabled,
            'total_points'          => $this->whenLoaded('points', fn() => $this->points?->total_points ?? 0),
            'tree_state'            => $this->whenLoaded('productivityTree', fn() => $this->productivityTree?->tree_state),
            'created_at'            => $this->created_at->toDateString(),
        ];
    }
}
