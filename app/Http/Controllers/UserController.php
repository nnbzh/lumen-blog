<?php

namespace App\Http\Controllers;

use App\Helpers\Pagination;

class UserController extends BaseController
{
    public function favourites() {
        return $this->successResponse(Pagination::handle(
            request()
                ->user()
                ->posts()
                ->with(['author', 'viewCount', 'category', 'images'])
                ->withCount(['likes', 'dislikes', 'comments'])
                ->paginate(10)));
    }
}