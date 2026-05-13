<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'is_admin',
        'chronotype',
        'activity_preference',
        'main_goals',
        'dark_mode',
        'language',
        'notifications_enabled',
        'app_tracking_enabled',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at'     => 'datetime',
        'password'              => 'hashed',
        'is_admin'              => 'boolean',
        'dark_mode'             => 'boolean',
        'notifications_enabled' => 'boolean',
        'app_tracking_enabled'  => 'boolean',
        'main_goals'            => 'array',
    ];

    // ==================== Relations ====================

    public function activitySettings()
    {
        return $this->hasMany(UserActivitySetting::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function appUsageLogs()
    {
        return $this->hasMany(AppUsageLog::class);
    }

    public function appUsageLimits()
    {
        return $this->hasMany(AppUsageLimit::class);
    }

    public function tipHistory()
    {
        return $this->hasMany(UserTipHistory::class);
    }

    public function tipFeedbacks()
    {
        return $this->hasMany(TipFeedback::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function points()
    {
        return $this->hasOne(UserPoints::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function productivityTree()
    {
        return $this->hasOne(ProductivityTree::class);
    }

    public function storePurchases()
    {
        return $this->hasMany(UserStorePurchase::class);
    }

    public function weeklyChallenges()
    {
        return $this->hasMany(WeeklyChallenge::class);
    }

    public function notifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    // ==================== Helpers ====================

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function getTotalPointsAttribute(): int
    {
        return $this->points?->total_points ?? 0;
    }
}
