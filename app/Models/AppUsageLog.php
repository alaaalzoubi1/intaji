<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'app_package', 'app_name', 'app_category', 'usage_date', 'duration_minutes',
    ];

    protected $casts = [
        'usage_date' => 'date',
        'duration_minutes' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationHoursAttribute(): float
    {
        return round($this->duration_minutes / 60, 2);
    }
}
