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

    protected $appends = ['is_fav'];

    protected $fillable = [
        'title',
        'img_src',
        'content',
        'category_id',
        'user_id',
        'short_description'
    ];

    protected $casts = [
        'created_at' => "datetime:d-m-Y H:m"
    ];

    protected $hidden = [
        'updated_at'
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function likes() {
        return $this->hasMany(PostUserReaction::class, 'post_id', 'id')->where('reaction', true);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function dislikes() {
        return $this->hasMany(PostUserReaction::class, 'post_id', 'id')->where('reaction', false);
    }

    public function getIsFavAttribute() {
        return request()->user()?->posts()->where('id', $this->id)->exists();
    }
}