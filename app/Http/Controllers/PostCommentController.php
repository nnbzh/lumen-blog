<?php

namespace App\Http\Controllers;

use App\Services\PostCommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostCommentController extends BaseController
{
    private PostCommentService $commentService;

    public function __construct(PostCommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @OA\Get   (
     *     path="/api/posts/{id}/comments",
     *     summary = "Get comments for post",
     *     operationId="posts.comments",
     *     tags={"posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
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
    public function list($id) {
        return $this->successResponse($this->commentService->list($id));
    }


    /**
     * @OA\Post(
     ** path="/api/comments",
     *   tags={"comments"},
     *   summary="Create comment",
     *   operationId="comments.create",
     *   security={{"bearer": {}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="comment",
     *             description="Content of the comment",
     *             type="string",
     *           ),
     *           @OA\Property(
     *             property="post_id",
     *             description="post id",
     *             type="integer",
     *           ),
     *           @OA\Property(
     *             property="parent_id",
     *             description="id of the parent comment(send if answer)",
     *             type="string",
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
    public function create(Request $request) {
        $validated = $this->validate($request, [
            'user_id'   => "required|int|exists:users,id",
            'comment'   => "required|string",
            "post_id"   => "required|int|exists:posts,id",
            "parent_id" => "nullable|int|exists:post_comments,id",
        ]);

        return $this->successResponse($this->commentService->create($validated));
    }
}