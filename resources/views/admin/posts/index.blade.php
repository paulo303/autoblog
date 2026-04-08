@extends('layouts.admin')

@section('title', 'Posts')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white">Posts</h1>
        <p class="mt-1 text-sm text-zinc-500">{{ $posts->total() }} post(s) no total</p>
    </div>
    <div class="flex items-center gap-3">
        <a
            href="{{ route('admin.posts.generate-from-youtube.create') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-zinc-700 bg-zinc-800 px-4 py-2.5 text-sm font-semibold text-zinc-300 hover:bg-zinc-700 hover:text-white transition-colors"
        >
            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
            Gerar do YouTube
        </a>
        <a
            href="{{ route('admin.posts.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo post
        </a>
    </div>
</div>

<div class="rounded-xl border border-zinc-800 bg-zinc-900 overflow-hidden">
    @if ($posts->isEmpty())
        <div class="py-20 text-center text-zinc-500">
            <p>Nenhum post encontrado.</p>
            <a href="{{ route('admin.posts.create') }}" class="mt-3 inline-block text-sm text-indigo-400 hover:text-indigo-300">Criar primeiro post →</a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-zinc-800 text-left text-xs text-zinc-500 uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Título</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium hidden sm:table-cell">Criado em</th>
                    <th class="px-6 py-4 font-medium hidden md:table-cell">Atualizado em</th>
                    <th class="px-6 py-4 font-medium text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @foreach ($posts as $post)
                    <tr class="hover:bg-zinc-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-zinc-100">{{ $post->title }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $post->status->badgeClass() }}">
                                {{ $post->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-zinc-400 hidden sm:table-cell">
                            {{ $post->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-zinc-400 hidden md:table-cell">
                            {{ $post->updated_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.posts.show', $post) }}" class="text-zinc-400 hover:text-white transition-colors" title="Visualizar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-zinc-400 hover:text-indigo-400 transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Excluir este post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-zinc-400 hover:text-red-400 transition-colors" title="Excluir">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($posts->hasPages())
            <div class="px-6 py-4 border-t border-zinc-800">
                {{ $posts->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
