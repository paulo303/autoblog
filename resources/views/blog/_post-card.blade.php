<article class="group rounded-xl border border-zinc-800 bg-zinc-900 overflow-hidden hover:border-zinc-700 transition-colors">
    @php $cover = $post->images->firstWhere('is_cover', true) ?? $post->images->first(); @endphp

    @if ($cover)
        <a href="{{ route('blog.show', $post->slug) }}">
            <img
                src="{{ Storage::url($cover->path) }}"
                alt="{{ $post->title }}"
                class="w-full h-52 object-cover opacity-80 group-hover:opacity-100 transition-opacity"
            >
        </a>
    @endif

    <div class="p-6">
        <div class="flex items-center gap-2 text-xs text-zinc-500 mb-3">
            <span>Daily Tech News</span>
            <span>·</span>
            <time datetime="{{ $post->published_at?->toDateString() }}">
                {{ $post->published_at?->translatedFormat('d \d\e F \d\e Y') ?? $post->created_at->translatedFormat('d \d\e F \d\e Y') }}
            </time>
        </div>

        <h2 class="text-lg font-semibold text-white leading-snug mb-2 group-hover:text-indigo-400 transition-colors">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h2>

        @if ($post->excerpt)
            <p class="text-sm text-zinc-400 leading-relaxed line-clamp-3">{{ $post->excerpt }}</p>
        @endif

        <a
            href="{{ route('blog.show', $post->slug) }}"
            class="mt-4 inline-flex items-center gap-1.5 text-xs font-medium text-indigo-400 hover:text-indigo-300 transition-colors"
        >
            Ler post completo
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</article>
