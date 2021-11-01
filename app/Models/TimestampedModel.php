<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimestampedModel extends Model
{
    public $timestamps = true;

    protected $hidden  = [
        'created_at',
        'updated_at'
    ];
}