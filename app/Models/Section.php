<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'name_en', 'description', 'icon', 'color', 'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class)->orderBy('order');
    }

    public function activeActivities()
    {
        return $this->hasMany(Activity::class)->where('is_active', true)->orderBy('order');
    }

    public function tips()
    {
        return $this->hasMany(Tip::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
