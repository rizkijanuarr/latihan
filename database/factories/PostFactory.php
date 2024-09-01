<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'category_id' => rand(1, 10),
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(true),
            'views' => 1000,
        ];
    }
}
