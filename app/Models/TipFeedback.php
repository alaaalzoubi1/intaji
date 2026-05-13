<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipFeedback extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tip_id', 'is_helpful', 'shown_at'];

    protected $casts = [
        'is_helpful' => 'boolean',
        'shown_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tip()
    {
        return $this->belongsTo(Tip::class);
    }
}
