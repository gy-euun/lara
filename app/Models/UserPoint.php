<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'points',
        'reason',
        'related_type',
        'related_id'
    ];

    protected $casts = [
        'points' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function related()
    {
        return $this->morphTo();
    }

    public static function award(User $user, int $points, string $reason, Model $related = null)
    {
        return static::create([
            'user_id' => $user->id,
            'points' => $points,
            'reason' => $reason,
            'related_type' => $related ? get_class($related) : null,
            'related_id' => $related ? $related->id : null
        ]);
    }
} 