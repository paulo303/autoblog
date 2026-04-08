<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\PostImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

final class DestroyPostImageController
{
    public function __invoke(PostImage $image): RedirectResponse
    {
        $postId = $image->post_id;
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('admin.posts.edit', $postId)
            ->with('success', 'Imagem removida com sucesso!');
    }
}
