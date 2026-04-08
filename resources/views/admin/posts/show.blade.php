@extends('layouts.admin')

@section('title', $post->title)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.posts.index') }}" class="text-zinc-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-white">Visualizar Post</h1>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center gap-2 rounded-lg border border-zinc-700 px-4 py-2 text-sm font-medium text-zinc-300 hover:border-zinc-500 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar
        </a>
        @if ($post->status->isPublished())
            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                Ver no blog
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        @endif
    </div>
</div>

<div class="max-w-3xl space-y-6">
    <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-6 space-y-4">
        <div class="flex items-start justify-between gap-4">
            <h2 class="text-xl font-semibold text-white leading-snug">{{ $post->title }}</h2>
            <span class="shrink-0 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $post->status->badgeClass() }}">
                {{ $post->status->label() }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-zinc-500">Criado em</span>
                <p class="text-zinc-300 mt-0.5">{{ $post->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <span class="text-zinc-500">Atualizado em</span>
                <p class="text-zinc-300 mt-0.5">{{ $post->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @if ($post->published_at)
                <div>
                    <span class="text-zinc-500">Publicado em</span>
                    <p class="text-zinc-300 mt-0.5">{{ $post->published_at->format('d/m/Y H:i') }}</p>
                </div>
            @endif
            <div>
                <span class="text-zinc-500">Slug</span>
                <p class="text-zinc-300 mt-0.5 font-mono text-xs">{{ $post->slug }}</p>
            </div>
        </div>

        @if ($post->excerpt)
            <div class="border-t border-zinc-800 pt-4">
                <span class="text-xs text-zinc-500 uppercase tracking-wider">Resumo</span>
                <p class="mt-1.5 text-sm text-zinc-400">{{ $post->excerpt }}</p>
            </div>
        @endif

        <div class="border-t border-zinc-800 pt-4">
            <span class="text-xs text-zinc-500 uppercase tracking-wider">Conteúdo</span>
            <div class="mt-2 text-sm text-zinc-300 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</div>
        </div>
    </div>

    @if ($post->images->isNotEmpty())
        <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-6">
            <h3 class="text-sm font-medium text-zinc-300 mb-4">Imagens ({{ $post->images->count() }})</h3>
            <div class="grid grid-cols-3 gap-3 sm:grid-cols-4">
                @foreach ($post->images as $image)
                    <div class="relative rounded-lg overflow-hidden border border-zinc-700">
                        <img src="{{ Storage::url($image->path) }}" alt="{{ $image->filename }}" class="w-full h-24 object-cover">
                        @if ($image->is_cover)
                            <span class="absolute top-1 left-1 rounded text-xs bg-indigo-600 px-1.5 py-0.5 text-white font-medium">Capa</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
