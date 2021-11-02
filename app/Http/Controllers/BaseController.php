<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;

class BaseController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Info(
     *   title="Blog Documentation",
     *   version="1.0",
     *   @OA\Contact(
     *     email="nurassyl.balgabay@yandex.ru",
     *     name="Blog Ananasik"
     *   )
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     in="header",
     *     securityScheme="bearer",
     *     scheme="bearer"
     * )
     */
}