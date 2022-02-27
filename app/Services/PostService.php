<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Models\Post;
use App\Models\PostImage;

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
        $images = $attributes['images'] ?? [];
        unset($attributes['images']);
        $post   = Post::query()->updateOrCreate($attributes);

        if (! empty($attributes['images'])) {
            foreach ($images as $image) {
                $src    = Storage::disk('images')->put($post->id, $image);
                $image  = PostImage::query()->create(
                    [
                        'post_id'   => $post->id,
                        'src'       => $src
                    ]
                );
            }
        }

        return $post->load('images');
    }

    public function edit($id, array $attributes) {
        $post = Post::query()->where('id', $id)->firstOrFail();
        $post->update($attributes);

        return $post;
    }

    public function get($id) {
        return Post::query()
            ->with(['author', 'viewCount', 'images', 'category'])
            ->withCount('likes', 'dislikes', 'comments')
            ->where('id', $id)
            ->firstOrFail();
    }
}
