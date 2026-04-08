<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class PostController
{
    public function index(): View
    {
        $posts = Post::orderByDesc('created_at')->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $statuses = PostStatus::cases();

        return view('admin.posts.create', compact('statuses'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('images');

        if ($data['status'] === PostStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        $this->handleImageUploads($request, $post);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post criado com sucesso!');
    }

    public function show(Post $post): View
    {
        $post->load('images');

        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $post->load('images');
        $statuses = PostStatus::cases();

        return view('admin.posts.edit', compact('post', 'statuses'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->safe()->except('images');

        if ($data['status'] === PostStatus::Published->value && empty($data['published_at']) && ! $post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        $this->handleImageUploads($request, $post);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post excluído com sucesso!');
    }

    private function handleImageUploads(StorePostRequest|UpdatePostRequest $request, Post $post): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $existingCount = $post->images()->count();

        foreach ($request->file('images') as $index => $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->store('post-images', 'public');

            $post->images()->create([
                'filename' => $filename,
                'path' => $path,
                'is_cover' => $existingCount === 0 && $index === 0,
                'order' => $existingCount + $index,
            ]);
        }
    }
}
