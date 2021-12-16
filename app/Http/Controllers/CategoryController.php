<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends BaseController
{
    public function list() {
        return $this->successResponse(Category::query()->get());
    }

    public function create() {
        $validated = $this->validate(request(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        return $this->successResponse(Category::query()->updateOrCreate($validated));
    }

    public function edit($id) {
        $validated = $this->validate(request(), [
            'name' => 'nullable',
            'slug' => 'nullable'
        ]);

        return $this->successResponse(Category::query()->where('id', $id)->update($validated));
    }

    public function get($id) {
        return $this->successResponse(Category::query()->findOrFail($id));
    }

    public function delete($id) {
        return $this->successResponse(Category::query()->where('id', $id)->delete());
    }
}