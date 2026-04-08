<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(2),
            /** @phpstan-ignore argument.type */
            'content' => implode("\n\n", fake()->paragraphs(5)),
            'status' => PostStatus::Draft,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => PostStatus::Published,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => PostStatus::Archived,
            'published_at' => fake()->dateTimeBetween('-2 years', '-1 year'),
        ]);
    }
}
