<?php

namespace App\Http\Controllers;

use App\Services\PostCommentComplainService;
use Illuminate\Http\Request;

class PostCommentComplainController extends BaseController
{
    private PostCommentComplainService $postCommentComplainService;

    public function __construct(PostCommentComplainService $postCommentComplainService)
    {
        $this->postCommentComplainService = $postCommentComplainService;
    }

    public function create(Request $request) {
        $validated = $this->validate($request, [
            'post_comment_id'   => 'required|int|exists:post_comments,id',
            'message'           => 'required|string'
        ]);

        return $this->successResponse($this->postCommentComplainService->create($validated));
    }

    public function list(Request $request) {
        return $this->successResponse($this->postCommentComplainService->list($request->all()));
    }

    public function process($id, Request $request) {
        $validated = [
            'status' => 'required|boolean'
        ];

        if ($validated['status']) {
            $this->postCommentComplainService->accept($id);

            return $this->successResponse(null);
        }

        $this->postCommentComplainService->decline($id);

        return $this->successResponse(null);
    }
}