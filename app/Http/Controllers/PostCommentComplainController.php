<?php

namespace App\Http\Controllers;

use App\Services\PostCommentComplainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostCommentComplainController extends BaseController
{
    private PostCommentComplainService $postCommentComplainService;

    public function __construct(PostCommentComplainService $postCommentComplainService)
    {
        $this->postCommentComplainService = $postCommentComplainService;
    }

    /**
     * @OA\Post(
     ** path="/api/complains",
     *   tags={"complains"},
     *   summary="Create complain for comment",
     *   operationId="comments.complain.create",
     *   security={{"bearer": {}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="post_comment_id",
     *             description="Id of the comment",
     *             type="int",
     *           ),
     *           @OA\Property(
     *             property="message",
     *             description="Complain message",
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
            'post_comment_id'   => 'required|int|exists:post_comments,id',
            'message'           => 'required|string'
        ]);

        return $this->successResponse($this->postCommentComplainService->create($validated));
    }

    /**
     * @OA\Get   (
     *     path="/api/complains",
     *     summary = "Get complains",
     *     operationId="complains",
     *     tags={"complains"},
     *     security={{"bearer": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Returns data"
     *     ),
     * )
     *
     */
    public function list(Request $request) {
        return $this->successResponse($this->postCommentComplainService->list($request->all()));
    }

    /**
     * @OA\Get   (
     *     path="/api/complains/{id}/process",
     *     summary = "Accept or reject complain",
     *     operationId="complains.process",
     *     tags={"complains"},
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="comlain id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns data"
     *     ),
     * )
     *
     */
    public function process($id): JsonResponse
    {
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