<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title'         => $this->faker->title,
            'img_src'       => $this->faker->url,
            'content'       => $this->faker->text,
            'category_id'   => Category::factory()->create()->id,
            'user_id'       => User::factory()->create()->id
        ];
    }
}