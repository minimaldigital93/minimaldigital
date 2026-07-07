<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="{{ setting('primary_color', '#6366f1') }}">

    @include('partials.seo')

    <link rel="icon" type="image/svg+xml" href="{{ media_url(setting('favicon', '/images/brand/favicon.svg')) }}">
    <link rel="apple-touch-icon" href="{{ media_url(setting('favicon', '/images/brand/favicon.svg')) }}">
    <link rel="manifest" href="/manifest.webmanifest">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet">

    {{-- Apply saved theme before paint to avoid a flash --}}
    <script>
        (function () {
            var t = localStorage.getItem('theme') || '{{ setting('default_theme', 'auto') }}';
            var dark = t === 'dark' || (t === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {!! setting('analytics_code') !!}
</head>
<body class="min-h-screen flex flex-col">

    @include('partials.navbar')

    <main id="main" class="flex-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js').catch(function () {});
            });
        }
    </script>
</body>
</html>
