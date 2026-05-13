<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyChallenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description',
        'week_start', 'week_end', 'targets',
        'status', 'reward_points', 'completed_at',
    ];

    protected $casts = [
        'week_start' => 'date',
        'week_end' => 'date',
        'targets' => 'array',
        'reward_points' => 'integer',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeThisWeek($query)
    {
        return $query->where('week_start', now()->startOfWeek());
    }

    public function markCompleted(): void
    {
        $this->update(['status' => 'completed', 'completed_at' => now()]);
        $this->user->points->addPoints($this->reward_points, 'challenge_won', $this);
    }
}
