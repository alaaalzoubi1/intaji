<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    // أنواع القياس المدعومة
    const MEASUREMENT_YES_NO     = 'yes_no';
    const MEASUREMENT_PAGES      = 'pages';
    const MEASUREMENT_MINUTES    = 'minutes';
    const MEASUREMENT_COUNT      = 'count';
    const MEASUREMENT_PERCENTAGE = 'percentage';
    const MEASUREMENT_RATING     = 'rating';
    const MEASUREMENT_TEXT       = 'text';
    const MEASUREMENT_TIMER      = 'timer';

    protected $fillable = [
        'section_id', 'name', 'description', 'icon',
        'measurement_type', 'unit', 'points',
        'repeat_type', 'specific_days',
        'default_reminder_time', 'is_active', 'order',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'specific_days' => 'array',
        'points'        => 'integer',
        'order'         => 'integer',
    ];

    // ==================== Relations ====================

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function userSettings()
    {
        return $this->hasMany(UserActivitySetting::class);
    }

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function tips()
    {
        return $this->hasMany(Tip::class);
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    // ==================== Helpers ====================

    /**
     * هل النشاط مجدول لهذا اليوم؟
     */
    public function isScheduledForDay(int $dayOfWeek): bool
    {
        return match ($this->repeat_type) {
            'daily'          => true,
            'specific_days'  => in_array($dayOfWeek, $this->specific_days ?? []),
            'odd_days'       => $dayOfWeek % 2 !== 0,
            'even_days'      => $dayOfWeek % 2 === 0,
            default          => true,
        };
    }

    /**
     * هل نوع القياس رقمي؟
     */
    public function isNumericMeasurement(): bool
    {
        return in_array($this->measurement_type, [
            self::MEASUREMENT_PAGES,
            self::MEASUREMENT_MINUTES,
            self::MEASUREMENT_COUNT,
            self::MEASUREMENT_PERCENTAGE,
        ]);
    }
}
