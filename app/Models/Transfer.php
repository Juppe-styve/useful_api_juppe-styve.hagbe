<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        "user_id",
        "receiver_id",
        "amount",
        "status"
    ];
}