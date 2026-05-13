<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUsageLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'app_package', 'daily_limit_minutes', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'daily_limit_minutes' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
