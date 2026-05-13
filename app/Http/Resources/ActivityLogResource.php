<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                  => $this->id,
            'activity_id'         => $this->activity_id,
            'activity'            => $this->whenLoaded('activity', fn() => [
                'id'               => $this->activity->id,
                'name'             => $this->activity->name,
                'measurement_type' => $this->activity->measurement_type,
            ]),
            'log_date'            => $this->log_date->toDateString(),
            'value_bool'          => $this->value_bool,
            'value_numeric'       => $this->value_numeric,
            'value_rating'        => $this->value_rating,
            'value_text'          => $this->value_text,
            'value_seconds'       => $this->value_seconds,
            'is_completed'        => $this->isCompleted(),
            'input_method'        => $this->input_method,
            'failure_reason'      => $this->failure_reason,
            'failure_reason_note' => $this->failure_reason_note,
            'note'                => $this->note,
            'evidence_image'      => $this->evidence_image ? asset('storage/' . $this->evidence_image) : null,
            'edited_at'           => $this->edited_at,
            'created_at'          => $this->created_at,
        ];
    }
}
