<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionTime extends Model
{
    protected $fillable = [
        "task_name",
        "start_time",
        "end_time",
        "user_id"
    ];
}