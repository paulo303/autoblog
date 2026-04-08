<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Daily Tech News</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased min-h-screen flex flex-col">

    <header class="border-b border-zinc-800 bg-zinc-900">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('blog.index') }}" class="text-lg font-bold tracking-tight text-white hover:text-indigo-400 transition-colors">
                    Daily Tech News
                </a>
                <span class="text-zinc-600">|</span>
                <a href="{{ route('admin.posts.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">
                    Painel Admin
                </a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-zinc-500">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-zinc-400 hover:text-red-400 transition-colors">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-8">

        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-green-400 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 flex items-center gap-3 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-red-400 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
