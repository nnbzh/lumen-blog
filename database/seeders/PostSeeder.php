<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $category   = Category::factory()->create();
        $user       = User::factory()->create();
        Post::factory()->count(1)->create(
            [
                'user_id'       => $user->id,
                'category_id'   => $category->id
            ]
        );
    }
}