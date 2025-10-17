<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserModules extends Model
{
    protected $fillable = [
        "user_id",
        "module_id",
        "active"
    ];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
