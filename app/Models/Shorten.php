<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Shorten extends Pivot
{
    protected $fillable = [
        "original_url",
        "custom_code",
        "clicks",
        "user_id",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}