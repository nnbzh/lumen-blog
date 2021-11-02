<?php

namespace App\Services;

use App\Models\PostUserReaction;

class PostReactionService
{
    public function react(array $attributes) {
        $postUser = PostUserReaction::query()
            ->firstOrCreate(["user_id" => $attributes['user_id'], "post_id" => $attributes['post_id']]);
        $postUser->reaction = $attributes['reaction'];
        $postUser->saveOrFail();

        return $postUser;
    }
}