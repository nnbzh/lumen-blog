<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Models\PostCommentComplain;

class PostCommentComplainService
{
    public function create(array $attributes) {
        return PostCommentComplain::query()->updateOrCreate($attributes);
    }

    public function accept($id) {
        $complain = PostCommentComplain::query()->findOrFail($id);
        $complain->is_accepted = true;
        $complain->comment()->delete();
        $complain->saveOrFail();
    }

    public function decline($id) {
        $complain = PostCommentComplain::query()->findOrFail($id);
        $complain->is_accepted = false;
        $complain->saveOrFail();
    }

    public function list(array $params)
    {
        return Pagination::handle(PostCommentComplain::query()->whereNull('is_accepted')->paginate(15));
    }

}