<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserModules extends Pivot
{
    protected $fillable = [
        "user_id",
        "module_id",
        "active"
    ];
}