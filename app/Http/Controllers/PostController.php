<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends BaseController
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @OA\Get   (
     *     path="/api/posts",
     *     summary = "List of posts",
     *     operationId="posts.list",
     *     tags={"posts"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page num",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns data"
     *     ),
     * )
     *
     */
    public function list(Request $request): JsonResponse
    {
        return $this->successResponse($this->postService->list($request->all()));
    }

    /**
     * @OA\Post(
     ** path="/api/posts",
     *   tags={"posts"},
     *   summary="Create post",
     *   operationId="posts.create",
     *   security={{"bearer": {}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="title",
     *             description="Title",
     *             type="string",
     *           ),
     *           @OA\Property(
     *             property="short_description",
     *             description="short_description",
     *             type="string",
     *           ),
     *           @OA\Property(
     *             property="content",
     *             description="content",
     *             type="string",
     *           ),
     *           @OA\Property(
     *             property="category_id",
     *             description="category_id",
     *             type="int",
     *           ),
     *         ),
     *       ),
     *     ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *   ),
     *)
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'title'             => 'required|string',
            'short_description' => 'required|string',
            'content'           => 'required|string',
            'category_id'       => 'required|exists:categories,id',
            'images'            => 'nullable',
            'images.*'          => 'nullable|file|mimes:png,jpeg,png,svg'
        ]);

        $validated['user_id'] = $request->user()->id;

        return $this->successResponse($this->postService->create($validated));
    }

    public function edit(Request $request, $id): JsonResponse
    {
        $validated = $this->validate($request, [
            'title'             => 'nullable|string',
            'short_description' => 'nullable|string',
            'content'           => 'nullable|string',
            'category_id'       => 'nullable|exists:categories,id',
        ]);

        $validated['user_id'] = $request->user()->id;

        return $this->successResponse($this->postService->edit($id, $validated));
    }

    public function get($id) {
        $post = $this->postService->get($id);
        $views = $post->viewCount()->firstOrCreate();
        $views->increment('count');
        $views->save();

        return $this->successResponse($this->postService->get($id));
    }

    public function like($id, Request $request) {
        $request->user()->posts()->attach(['post_id' => $id]);

        return $this->successResponse(true);
    }

    public function unlike($id, Request $request) {
        $request->user()->posts()->detach(['post_id' => $id]);

        return $this->successResponse(null);
    }

    public function delete($id) {
        $post = $this->postService->get($id);
        $post->delete();

        return $this->successResponse(null);
    }
}
