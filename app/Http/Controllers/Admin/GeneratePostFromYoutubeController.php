<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Jobs\GeneratePostFromYoutubeJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class GeneratePostFromYoutubeController
{
    public function create(): View
    {
        return view('admin.posts.generate-from-youtube');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'youtube_url' => ['required', 'url', 'regex:/youtube\.com|youtu\.be/'],
        ], [
            'youtube_url.required' => 'Informe o link do vídeo do YouTube.',
            'youtube_url.url' => 'O link informado não é uma URL válida.',
            'youtube_url.regex' => 'O link deve ser de um vídeo do YouTube.',
        ]);

        dispatch(new GeneratePostFromYoutubeJob($request->string('youtube_url')->toString()));

        return to_route('admin.posts.generate-from-youtube.create')
            ->with('success', 'O post está sendo gerado em segundo plano. Ele aparecerá na lista em breve!');
    }
}
