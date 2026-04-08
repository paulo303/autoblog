<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

final class BlogController
{
    public function index(): View
    {
        $posts = Post::query()->published()
            ->latestPublished()
            ->with('images')
            ->paginate(5);

        return view('blog.index', ['posts' => $posts]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()->published()
            ->with('images')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', ['post' => $post]);
    }
}
