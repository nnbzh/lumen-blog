<?php

namespace App\Http\Controllers;

use App\Services\PostReactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostUserReactionController extends BaseController
{
    private PostReactionService $postReactionService;

    public function __construct(PostReactionService $postReactionService)
    {
        $this->postReactionService = $postReactionService;
    }

    /**
     * @OA\Get(
     ** path="/api/posts/{id}/react",
     *   tags={"posts"},
     *   summary="like/dislike post",
     *   operationId="posts.react",
     *   security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="post id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="reaction",
     *         in="query",
     *         description="0(dislike) or 1(like) or null to remove",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *   ),
     *)
     * @return JsonResponse
     * @throws ValidationException
     */
    public function react($id, Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'user_id'   => 'required|exists:users,id',
            'reaction'  => 'present|nullable|boolean'
        ]);
        $validated['post_id'] = $id;

        return $this->successResponse($this->postReactionService->react($validated));
    }
}