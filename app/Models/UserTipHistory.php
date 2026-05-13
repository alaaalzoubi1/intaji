<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTipHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tip_id', 'ai_tip_content', 'shown_date'];

    protected $casts = ['shown_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tip()
    {
        return $this->belongsTo(Tip::class);
    }
}
