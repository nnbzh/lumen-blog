<?php

namespace App\Http\Controllers;

use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;

class ImageController extends BaseController
{
    public function create($id) {
        $this->validate(request(),
            [
                'image' => 'required|file|mimes:png,jpg,jpeg,gif'
            ]
        );

        $src    = Storage::disk('images')->put($id, request()->file('image'));
        $image  = PostImage::query()->create(
            [
                'post_id'   => $id,
                'src'       => $src
            ]
        );

        return $this->successResponse($image);
    }
}