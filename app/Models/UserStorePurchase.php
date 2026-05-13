<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStorePurchase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'store_item_id', 'purchased_at', 'is_active'];

    protected $casts = [
        'purchased_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeItem()
    {
        return $this->belongsTo(StoreItem::class);
    }
}
