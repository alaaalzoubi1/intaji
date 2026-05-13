<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'icon', 'unlock_condition', 'points_reward', 'is_active',
    ];

    protected $casts = [
        'unlock_condition' => 'array',
        'is_active'        => 'boolean',
        'points_reward'    => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')
                    ->withPivot('earned_at')->withTimestamps();
    }
}
