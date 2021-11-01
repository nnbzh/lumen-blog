<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends TimestampedModel
{
    protected $table = 'post_comments';

    protected $fillable = [
        'user_id',
        'comment',
        'parent_id',
    ];


}