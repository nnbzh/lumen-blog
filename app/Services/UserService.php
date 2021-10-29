<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $attributes) {
        $user = new User();
        $user->fill($attributes);

        if (! empty($attributes['password'])) $user->password = Hash::make($attributes['password']);

        $user->saveOrFail();

        return $user;
    }

}