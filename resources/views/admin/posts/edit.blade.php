@extends('layouts.admin')

@section('title', 'Editar Post')

@section('content')
<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('admin.posts.index') }}" class="text-zinc-400 hover:text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="text-2xl font-bold text-white">Editar Post</h1>
</div>

<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
    @csrf
    @method('PUT')
    @include('admin.posts._form')

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
            Salvar alterações
        </button>
        <a href="{{ route('admin.posts.index') }}" class="rounded-lg border border-zinc-700 px-5 py-2.5 text-sm font-medium text-zinc-300 hover:border-zinc-500 hover:text-white transition-colors">
            Cancelar
        </a>
    </div>
</form>
@endsection
