<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends TimestampedModel
{
    use HasFactory;

    protected $table = 'posts';

    protected $perPage = 15;

    protected $fillable = [
        'title',
        'img_src',
        'content',
        'category_id',
        'user_id',
        'short_description'
    ];

    public function likeCount(): HasOne
    {
        return $this->hasOne(PostLike::class, 'post_id', 'id');
    }

    public function viewCount(): HasOne
    {
        return $this->hasOne(PostView::class, 'post_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images() {
        return $this->hasMany(Image, 'post_id', 'id');
    }

    public function likes() {
        return $this->hasMany(PostUserReaction::class, 'post_id', 'id')->where('reaction', true);
    }

    public function dislikes() {
        return $this->hasMany(PostUserReaction::class, 'post_id', 'id')->where('reaction', false);
    }
}