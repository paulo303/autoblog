<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Daily Tech News')</title>
    <meta name="description" content="@yield('description', 'As últimas notícias do mundo da tecnologia.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased min-h-screen flex flex-col">

    <header class="border-b border-zinc-800 sticky top-0 z-50 bg-zinc-950/90 backdrop-blur-sm">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 group">
                <span class="text-xl font-bold tracking-tight text-white group-hover:text-indigo-400 transition-colors">
                    Daily Tech News
                </span>
            </a>
            <nav class="flex items-center gap-6 text-sm text-zinc-400">
                <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a>
                @auth
                    <a href="{{ route('admin.posts.index') }}" class="hover:text-white transition-colors">Admin</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-zinc-800 mt-16">
        <div class="max-w-4xl mx-auto px-4 py-8 text-center text-zinc-500 text-sm">
            &copy; {{ date('Y') }} Daily Tech News. Todos os direitos reservados.
        </div>
    </footer>

</body>
</html>
