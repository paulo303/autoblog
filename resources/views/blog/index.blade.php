@extends('layouts.app')

@section('title', 'Daily Tech News')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">

    <div class="mb-12">
        <h1 class="text-3xl font-bold tracking-tight text-white">Últimas notícias</h1>
        <p class="mt-2 text-zinc-500">As novidades mais recentes do mundo da tecnologia.</p>
    </div>

    <div id="posts-list" class="space-y-8">
        @forelse ($posts as $post)
            @include('blog._post-card', ['post' => $post])
        @empty
            <div class="text-center py-20 text-zinc-500">
                <p class="text-lg">Nenhum post publicado ainda.</p>
            </div>
        @endforelse
    </div>

    @if ($posts->hasMorePages())
        <div class="mt-12 text-center" id="load-more-container">
            <button
                id="load-more-btn"
                data-page="2"
                class="inline-flex items-center gap-2 rounded-lg border border-zinc-700 bg-zinc-900 px-6 py-3 text-sm font-medium text-zinc-300 hover:border-indigo-500 hover:text-white transition-all"
            >
                <span>Ler mais</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>
    @endif

</div>

<script>
    const btn = document.getElementById('load-more-btn');
    if (btn) {
        btn.addEventListener('click', async function () {
            const page = parseInt(this.dataset.page);
            btn.disabled = true;
            btn.innerHTML = '<span>Carregando...</span>';

            const response = await fetch(`?page=${page}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (response.ok) {
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newPosts = doc.querySelectorAll('#posts-list > article');
                const hasMore = doc.getElementById('load-more-btn');

                newPosts.forEach(post => {
                    document.getElementById('posts-list').appendChild(post);
                });

                if (hasMore) {
                    btn.dataset.page = page + 1;
                    btn.disabled = false;
                    btn.innerHTML = '<span>Ler mais</span><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
                } else {
                    document.getElementById('load-more-container').remove();
                }
            }
        });
    }
</script>
@endsection
