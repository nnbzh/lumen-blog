<?php

namespace App\Models;

class PostImage extends TimestampedModel
{
    protected $fillable = [
        'post_id',
        'src'
    ];

    public function getSrcAttribute($src) {
        return env('APP_URL').'/images/'.$src;
    }
}