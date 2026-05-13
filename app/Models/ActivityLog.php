<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'activity_id', 'log_date',
        'value_bool', 'value_numeric', 'value_rating', 'value_text', 'value_seconds',
        'input_method', 'failure_reason', 'failure_reason_note',
        'note', 'evidence_image', 'edited_at', 'edit_history',
    ];

    protected $casts = [
        'log_date'     => 'date',
        'value_bool'   => 'boolean',
        'value_numeric' => 'decimal:2',
        'edited_at'    => 'datetime',
        'edit_history' => 'array',
    ];

    // ==================== Relations ====================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // ==================== Helpers ====================

    /**
     * القيمة الموحدة بغض النظر عن نوع القياس
     */
    public function getValueAttribute(): mixed
    {
        return $this->value_bool
            ?? $this->value_numeric
            ?? $this->value_rating
            ?? $this->value_text
            ?? $this->value_seconds
            ?? null;
    }

    /**
     * هل النشاط منجز؟
     */
    public function isCompleted(): bool
    {
        if ($this->activity->measurement_type === Activity::MEASUREMENT_YES_NO) {
            return $this->value_bool === true;
        }
        return $this->getValue('value') !== null;
    }
}
