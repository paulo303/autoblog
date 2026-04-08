<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Post::factory(10)->published()->create();
        \App\Models\Post::factory(5)->create();
        \App\Models\Post::factory(3)->archived()->create();
    }
}
