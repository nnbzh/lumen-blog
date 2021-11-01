<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Traits\IssuesToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    use IssuesToken;

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();

        return $this->successResponse(null, "Успешный выход из системы.");
    }
}