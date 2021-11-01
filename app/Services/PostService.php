<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostService
{
    public function list(array $filters)
    {
        $sortByLikes    = $filters['sort_likes'] ?? null;
        $sortByDate     = $filters['sort_date'] ?? null;
        $categoryId     = $filters['category_id'] ?? null;
        $query          = Post::query();

        if (! empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (! empty($sortByDate)) {
            $query->latest();
        }

        if (! empty($sortByLikes)) {
            $query->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id');
            $query->orderBy('post_likes.count');
        }

        return Pagination::handle($query->paginate());
    }

    public function create(array $attributes) {
        $post = new Post();
        $post->fill($attributes);
    }

    public function get($id) {

    }
}