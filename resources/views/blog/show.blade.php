@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
<article class="max-w-3xl mx-auto px-4 py-12">

    <header class="mb-10">
        <div class="flex items-center gap-2 text-xs text-zinc-500 mb-4">
            <a href="{{ route('blog.index') }}" class="hover:text-zinc-300 transition-colors">Blog</a>
            <span>›</span>
            <span>{{ $post->title }}</span>
        </div>

        <h1 class="text-3xl font-bold tracking-tight text-white leading-tight mb-4">
            {{ $post->title }}
        </h1>

        <div class="flex items-center gap-3 text-sm text-zinc-500">
            <span class="font-medium text-zinc-400">Daily Tech News</span>
            <span>·</span>
            <time datetime="{{ $post->published_at?->toDateString() }}">
                {{ $post->published_at?->translatedFormat('d \d\e F \d\e Y') ?? $post->created_at->translatedFormat('d \d\e F \d\e Y') }}
            </time>
        </div>
    </header>

    @php $cover = $post->images->firstWhere('is_cover', true) ?? $post->images->first(); @endphp
    @if ($cover)
        <div class="mb-10 rounded-xl overflow-hidden">
            <img
                src="{{ Storage::url($cover->path) }}"
                alt="{{ $post->title }}"
                class="w-full max-h-96 object-cover"
            >
        </div>
    @endif

    <div class="prose prose-invert prose-zinc max-w-none
        prose-headings:font-semibold prose-headings:text-white
        prose-p:text-zinc-300 prose-p:leading-relaxed
        prose-a:text-indigo-400 prose-a:no-underline hover:prose-a:underline
        prose-strong:text-white
        prose-code:text-indigo-300 prose-code:bg-zinc-800 prose-code:px-1 prose-code:rounded
        prose-pre:bg-zinc-900 prose-pre:border prose-pre:border-zinc-800
        prose-blockquote:border-indigo-500 prose-blockquote:text-zinc-400
        prose-img:rounded-lg">
        {!! nl2br(e($post->content)) !!}
    </div>

    @if ($post->images->count() > 1)
        <div class="mt-12">
            <h2 class="text-sm font-semibold text-zinc-400 uppercase tracking-wider mb-4">Imagens</h2>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                @foreach ($post->images->skip($cover ? 1 : 0) as $image)
                    <img
                        src="{{ Storage::url($image->path) }}"
                        alt="{{ $post->title }}"
                        class="rounded-lg w-full h-40 object-cover border border-zinc-800"
                    >
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-12 pt-8 border-t border-zinc-800">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm text-zinc-400 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar ao blog
        </a>
    </div>

</article>
@endsection
