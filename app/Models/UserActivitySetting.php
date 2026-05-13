<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivitySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'activity_id',
        'is_enabled', 'reminder_time', 'smart_reminder', 'notifications_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'smart_reminder' => 'boolean',
        'notifications_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
