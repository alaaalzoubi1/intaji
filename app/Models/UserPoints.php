<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoints extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_points', 'available_points'];

    protected $casts = [
        'total_points' => 'integer',
        'available_points' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addPoints(int $amount, string $reason, Model $source): void
    {
        $this->increment('total_points', $amount);
        $this->increment('available_points', $amount);

        PointTransaction::create([
            'user_id' => $this->user_id,
            'amount' => $amount,
            'reason' => $reason,
            'source_type' => get_class($source),
            'source_id' => $source->id,
        ]);
    }

    public function spendPoints(int $amount, string $reason, Model $source): bool
    {
        if ($this->available_points < $amount) return false;

        $this->decrement('available_points', $amount);

        PointTransaction::create([
            'user_id' => $this->user_id,
            'amount' => -$amount,
            'reason' => $reason,
            'source_type' => get_class($source),
            'source_id' => $source->id,
        ]);

        return true;
    }
}
