<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends TimestampedModel
{
    protected $fillable = [
        'user_id',
        'src'
    ];
}