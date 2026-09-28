<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternLike extends Model
{
    protected $fillable = ['pattern_id', 'user_id'];

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}