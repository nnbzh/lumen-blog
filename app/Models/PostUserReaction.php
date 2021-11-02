<?php

namespace App\Models;

class PostUserReaction extends TimestampedModel
{
    protected $fillable = [
        'post_id',
        'user_id',
        'reaction'
    ];
}