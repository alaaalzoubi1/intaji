<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductivityTree extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'health', 'level', 'total_water', 'last_watered_at'];

    protected $casts = [
        'health' => 'integer',
        'level' => 'integer',
        'total_water' => 'integer',
        'last_watered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * حالة الشجرة البصرية بناءً على الصحة
     */
    public function getTreeStateAttribute(): string
    {
        return match (true) {
            $this->health >= 80 => 'flourishing',   // مزدهرة
            $this->health >= 50 => 'healthy',        // صحية
            $this->health >= 30 => 'stressed',       // متعبة
            $this->health >= 10 => 'wilting',        // ذابلة
            default => 'dead',           // ميتة
        };
    }

    public function water(int $amount = 1): void
    {
        $this->health = min(100, $this->health + $amount * 5);
        $this->total_water += $amount;
        $this->last_watered_at = now();

        // رفع المستوى كل 100 وحدة ماء
        $newLevel = (int)floor($this->total_water / 100) + 1;
        if ($newLevel > $this->level) $this->level = $newLevel;

        $this->save();
    }

    public function decay(int $amount = 5): void
    {
        $this->health = max(0, $this->health - $amount);
        $this->save();
    }
}
