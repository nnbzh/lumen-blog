<?php

namespace App\Models;

class PostComment extends TimestampedModel
{
    protected $table = 'post_comments';

    protected $with = [
        'answers'
    ];

    protected $fillable = [
        'user_id',
        'comment',
        'parent_id',
        'post_id'
    ];

    public function answers() {
        return $this->hasMany(PostComment::class, 'parent_id', 'id');
    }
}