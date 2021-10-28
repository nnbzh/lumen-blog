<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($data, $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }

    protected function errorResponse($code, $message = null, $data = null): JsonResponse
    {
        return response()->json([
            'status'    =>false,
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }
}