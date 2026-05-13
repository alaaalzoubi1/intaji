<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'asset_path', 'price_points', 'is_active'];

    protected $casts = [
        'price_points' => 'integer',
        'is_active' => 'boolean',
    ];

    public function purchases()
    {
        return $this->hasMany(UserStorePurchase::class);
    }
}
