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
            'user_id'           => 'required|exists:users,id'
        ]);

        return $this->successResponse($this->postService->create($validated));
    }


}