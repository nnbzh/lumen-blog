<?php

namespace App\Services;

use App\Models\PostComment;

class PostCommentService
{
    public function create(array $attributes) {
        return PostComment::query()->updateOrCreate($attributes);
    }

    public function list($id)
    {
        return PostComment::query()->with('answers')->whereNull('parent_id')->get();
    }
}