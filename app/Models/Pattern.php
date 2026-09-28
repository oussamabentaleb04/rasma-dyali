<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    public const SYMMETRIES = ['4-fold', '6-fold', '8-fold'];
    public const SHAPES = ['star', 'diamond', 'knot', 'floral'];

    protected $fillable = [
        'user_id', 'title', 'symmetry_type', 'base_shape', 'colors',
        'grid_density', 'is_public', 'is_featured', 'likes_count',
    ];

    protected $casts = [
        'colors' => 'array',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(PatternLike::class);
    }

    public function isLikedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }
}