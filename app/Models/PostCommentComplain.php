<?php

namespace App\Models;

class PostCommentComplain extends TimestampedModel
{
    protected $fillable = [
        'post_comment_id',
        'message',
        'is_accepted'
    ];

    public function comment() {
        return $this->belongsTo(PostComment::class);
    }
}
