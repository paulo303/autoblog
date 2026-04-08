<div class="space-y-5">

    @if ($errors->any())
        <div class="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <label for="title" class="block text-sm font-medium text-zinc-300 mb-1.5">Título <span class="text-red-400">*</span></label>
        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $post?->title) }}"
            required
            class="w-full rounded-lg border border-zinc-700 bg-zinc-800 px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('title') border-red-500 @enderror"
            placeholder="Título do post"
        >
        @error('title')
            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="excerpt" class="block text-sm font-medium text-zinc-300 mb-1.5">Resumo</label>
        <textarea
            id="excerpt"
            name="excerpt"
            rows="2"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-800 px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors resize-none @error('excerpt') border-red-500 @enderror"
            placeholder="Breve resumo exibido na listagem (opcional)"
        >{{ old('excerpt', $post?->excerpt) }}</textarea>
        @error('excerpt')
            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-medium text-zinc-300 mb-1.5">Conteúdo <span class="text-red-400">*</span></label>
        <textarea
            id="content"
            name="content"
            rows="14"
            required
            class="w-full rounded-lg border border-zinc-700 bg-zinc-800 px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors resize-y @error('content') border-red-500 @enderror"
            placeholder="Conteúdo completo do post..."
        >{{ old('content', $post?->content) }}</textarea>
        @error('content')
            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label for="status" class="block text-sm font-medium text-zinc-300 mb-1.5">Status <span class="text-red-400">*</span></label>
            <select
                id="status"
                name="status"
                required
                class="w-full rounded-lg border border-zinc-700 bg-zinc-800 px-3.5 py-2.5 text-sm text-zinc-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('status') border-red-500 @enderror"
            >
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" {{ old('status', $post?->status->value) === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="published_at" class="block text-sm font-medium text-zinc-300 mb-1.5">Data de publicação</label>
            <input
                type="datetime-local"
                id="published_at"
                name="published_at"
                value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}"
                class="w-full rounded-lg border border-zinc-700 bg-zinc-800 px-3.5 py-2.5 text-sm text-zinc-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('published_at') border-red-500 @enderror"
            >
            @error('published_at')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-zinc-300 mb-1.5">Imagens</label>
        <div class="rounded-lg border border-dashed border-zinc-700 bg-zinc-800/50 px-4 py-6 text-center hover:border-zinc-500 transition-colors">
            <input
                type="file"
                id="images"
                name="images[]"
                multiple
                accept="image/*"
                class="hidden"
                onchange="previewImages(this)"
            >
            <label for="images" class="cursor-pointer">
                <svg class="mx-auto w-8 h-8 text-zinc-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm text-zinc-400">Clique para selecionar imagens</span>
                <span class="block text-xs text-zinc-600 mt-1">PNG, JPG, GIF, WEBP</span>
            </label>
        </div>
        <div id="image-preview" class="mt-3 grid grid-cols-3 gap-3 sm:grid-cols-4"></div>
    </div>

    @if ($post && $post->images->isNotEmpty())
        <div>
            <p class="text-sm font-medium text-zinc-300 mb-3">Imagens existentes</p>
            <div class="grid grid-cols-3 gap-3 sm:grid-cols-4">
                @foreach ($post->images as $image)
                    <div class="relative group rounded-lg overflow-hidden border border-zinc-700">
                        <img src="{{ Storage::url($image->path) }}" alt="{{ $image->filename }}" class="w-full h-24 object-cover">
                        @if ($image->is_cover)
                            <span class="absolute top-1 left-1 rounded text-xs bg-indigo-600 px-1.5 py-0.5 text-white font-medium">Capa</span>
                        @endif
                        <form method="POST" action="{{ route('admin.images.destroy', $image) }}" class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-500 transition-colors" onclick="return confirm('Remover imagem?')">
                                Remover
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
    function previewImages(input) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'rounded-lg overflow-hidden border border-zinc-700';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-24 object-cover">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
