<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BallContainer extends Model
{
    protected $fillable = [
        'container_number',
        'quantity',
        'is_verified'
    ];
}
