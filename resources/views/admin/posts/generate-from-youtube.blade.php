@extends('layouts.admin')

@section('title', 'Gerar Post do YouTube')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-3 mb-1">
        <a href="{{ route('admin.posts.index') }}" class="text-zinc-500 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-white">Gerar Post do YouTube</h1>
    </div>
    <p class="mt-1 text-sm text-zinc-500 ml-7">Cole o link de um vídeo e a IA vai criar um post completo automaticamente.</p>
</div>

<div class="max-w-2xl">
    <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-6">
        <form action="{{ route('admin.posts.generate-from-youtube.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="youtube_url" class="block text-sm font-medium text-zinc-300 mb-2">
                    Link do vídeo do YouTube
                </label>
                <input
                    type="url"
                    id="youtube_url"
                    name="youtube_url"
                    value="{{ old('youtube_url') }}"
                    placeholder="https://www.youtube.com/watch?v=..."
                    autofocus
                    class="w-full rounded-lg border px-4 py-3 text-sm text-zinc-100 placeholder-zinc-500 bg-zinc-800 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors {{ $errors->has('youtube_url') ? 'border-red-500' : 'border-zinc-700' }}"
                >
                @error('youtube_url')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-lg border border-zinc-700/50 bg-zinc-800/50 px-4 py-3 mb-6">
                <p class="text-xs text-zinc-400 leading-relaxed">
                    <span class="font-medium text-zinc-300">Como funciona:</span>
                    A IA vai buscar informações do vídeo, tentar obter a transcrição e gerar um post completo em português com título, conteúdo e sugestões de imagem. O post será salvo como <span class="text-indigo-400">rascunho</span> para você revisar antes de publicar.
                </p>
            </div>

            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Gerar post com IA
            </button>
        </form>
    </div>
</div>
@endsection
