<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in — {{ setting('company_name', 'MinimalDigital') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ media_url(setting('favicon', '/images/brand/favicon.svg')) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    <script>
        (function () {
            var t = localStorage.getItem('theme') || 'auto';
            var dark = t === 'dark' || (t === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-100 dark:bg-slate-950 relative overflow-hidden p-4">

    {{-- Ambient background --}}
    <div class="pointer-events-none absolute -top-40 -left-40 w-[500px] h-[500px] rounded-full bg-primary-500/20 blur-3xl animate-pulse-glow"></div>
    <div class="pointer-events-none absolute -bottom-40 -right-40 w-[500px] h-[500px] rounded-full bg-purple-500/20 blur-3xl animate-pulse-glow"></div>
    <div class="pointer-events-none absolute inset-0 bg-grid"></div>

    <main class="relative w-full max-w-md animate-fade-up">
        <div class="glass rounded-3xl shadow-card-hover p-8 sm:p-10">
            <div class="text-center">
                <img src="{{ media_url(setting('logo', '/images/brand/logo.svg')) }}" alt="{{ setting('company_name', 'MinimalDigital') }}" class="mx-auto h-9 w-auto text-slate-900 dark:text-white">
                <h1 class="mt-6 text-2xl font-extrabold text-slate-900 dark:text-white">Welcome back</h1>
                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">Sign in to manage your website</p>
            </div>

            @if(session('status'))
                <p class="mt-5 text-sm text-emerald-600 text-center">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" value="Email or Username" />
                    <x-text-input id="email" name="email" type="text" class="mt-1.5 block w-full"
                                  :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" name="password" type="password" class="mt-1.5 block w-full"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="rounded border-slate-300 dark:border-slate-700 text-primary-600 focus:ring-primary-500">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary w-full">Sign in</button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-primary-500 transition-colors">← Back to {{ setting('company_name', 'MinimalDigital') }}</a>
        </p>
    </main>
</body>
</html>
