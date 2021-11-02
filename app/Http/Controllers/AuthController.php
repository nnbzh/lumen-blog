<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Traits\IssuesToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    use IssuesToken;

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     ** path="/api/register",
     *   tags={"auth"},
     *   summary="Sign up",
     *   operationId="register",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="email",
     *             description="Email",
     *             type="string",
     *           ),
     *           @OA\Property(
     *             property="password",
     *             description="Password",
     *             type="string",
     *           ),
     *           @OA\Property(
     *             property="password_confirmation",
     *             description="Password comfirmation",
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
    public function register(Request $request): JsonResponse
    {
        $rules = [
            'email'    => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/|confirmed'
        ];
        $this->validate($request, $rules);
        $user = $this->userService->create($request->all());

        return $this->successResponse($user);
    }

    /**
     * @OA\Post(
     ** path="/api/login",
     *   tags={"auth"},
     *   summary="Login",
     *   operationId="login",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="email",
     *             description="Email",
     *             type="string",
     *           ),
     *           @OA\Property(
     *             property="password",
     *             description="Password",
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
    public function login(Request $request): JsonResponse
    {
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required',
        ];
        $this->validate($request, $rules);
        $tokens = json_decode($this->issueToken($request)->getContent(), true);

        return $this->successResponse($tokens);
    }

    /**
     * @OA\Get   (
     *     path="/api/logout",
     *     summary = "Logout",
     *     operationId="logout",
     *     tags={"auth"},
     *     security={{"bearer": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Returns data"
     *     ),
     * )
     *
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();

        return $this->successResponse(null, "Успешный выход из системы.");
    }
}