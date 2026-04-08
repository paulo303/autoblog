<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostImage>
 */
final class PostImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'filename' => fake()->uuid().'.jpg',
            'path' => 'post-images/'.fake()->uuid().'.jpg',
            'is_cover' => false,
            'order' => 0,
        ];
    }
}
