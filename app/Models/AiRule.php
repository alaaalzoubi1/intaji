<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiRule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'rule_type', 'parameters', 'is_active'];

    protected $casts = [
        'parameters' => 'array',
        'is_active'  => 'boolean',
    ];

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOfType($query, string $type) { return $query->where('rule_type', $type); }
}
