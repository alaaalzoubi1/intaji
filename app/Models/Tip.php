<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tip extends Model
{
    use  SoftDeletes;

    protected $fillable = [
        'content', 'type', 'condition',
        'section_id', 'activity_id',
        'tip_category', 'is_active',
    ];

    protected $casts = [
        'condition' => 'array',
        'is_active' => 'boolean',
    ];

    public function section()  { return $this->belongsTo(Section::class); }
    public function activity() { return $this->belongsTo(Activity::class); }
    public function feedbacks() { return $this->hasMany(TipFeedback::class); }
    public function history()   { return $this->hasMany(UserTipHistory::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeStatic($query) { return $query->where('type', 'static'); }
    public function scopeConditional($query) { return $query->where('type', 'conditional'); }

    /**
     * تحقق من الشرط بناءً على بيانات المستخدم
     * condition example: {"metric":"activity_commitment","activity_id":1,"operator":"<","value":0.5}
     */
    public function evaluateCondition(array $userMetrics): bool
    {
        if ($this->type === 'static') return true;
        if (empty($this->condition)) return false;

        $c      = $this->condition;
        $key    = isset($c['activity_id'])
                    ? "{$c['metric']}_{$c['activity_id']}"
                    : $c['metric'];
        $actual = $userMetrics[$key] ?? null;

        if ($actual === null) return false;

        return match ($c['operator']) {
            '<'  => $actual < $c['value'],
            '<=' => $actual <= $c['value'],
            '>'  => $actual > $c['value'],
            '>=' => $actual >= $c['value'],
            '='  => $actual == $c['value'],
            default => false,
        };
    }
}
