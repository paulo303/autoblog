<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BlogController
{
    public function index(Request $request): View
    {
        $posts = Post::published()
            ->latestPublished()
            ->with('images')
            ->paginate(5);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = Post::published()
            ->with('images')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }
}
