<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Models\Post;

class PostService
{
    public function list(array $filters)
    {
        $sortByDate     = $filters['sort_date'] ?? null;
        $categoryId     = $filters['category_id'] ?? null;
        $keyword        = $filters['keyword'] ?? null;

        $query          = Post::query()
            ->with(['author', 'viewCount', 'category'])
            ->withCount(['likes', 'dislikes', 'comments']);

        if (! empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (! empty($keyword)) {
            $query->where('title', 'ilike', "%$keyword%");
        }

        if (! empty($sortByDate)) {
            $query->latest();
        }

        return Pagination::handle($query->paginate());
    }

    public function create(array $attributes) {
        return Post::query()->updateOrCreate($attributes);
    }

    public function get($id) {
        return Post::query()
            ->with(['author', 'viewCount', 'images', 'category'])
            ->withCount('likes', 'dislikes', 'comments')
            ->where('id', $id)
            ->firstOrFail();
    }
}