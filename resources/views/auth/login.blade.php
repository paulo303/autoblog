<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Daily Tech News</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased min-h-screen flex items-center justify-center">

    <div class="w-full max-w-sm px-4">
        <div class="mb-8 text-center">
            <a href="{{ route('blog.index') }}" class="text-2xl font-bold tracking-tight text-white hover:text-indigo-400 transition-colors">
                Daily Tech News
            </a>
            <p class="mt-2 text-sm text-zinc-500">Acesse o painel administrativo</p>
        </div>

        <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-8">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-300 mb-1.5">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-800 px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('email') border-red-500 @enderror"
                        placeholder="admin@autoblog.com"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-300 mb-1.5">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-800 px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="rounded border-zinc-700 bg-zinc-800 text-indigo-500 focus:ring-indigo-500">
                    <label for="remember" class="text-sm text-zinc-400">Lembrar de mim</label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-colors"
                >
                    Entrar
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-zinc-600">
            <a href="{{ route('blog.index') }}" class="hover:text-zinc-400 transition-colors">← Voltar ao blog</a>
        </p>
    </div>

</body>
</html>
