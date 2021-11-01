<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function list(Request $request) {
        return $this->successResponse($this->postService->list($request->all()));
    }

    public function create(Request $request) {
        return $this->successResponse($this->postService->create($request->all()));
    }


}