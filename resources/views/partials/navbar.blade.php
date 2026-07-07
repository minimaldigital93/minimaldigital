<header class="fixed inset-x-0 top-0 z-50" x-data="{ open: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 24">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 btn-primary">Skip to content</a>

    <nav :class="scrolled || open ? 'glass shadow-card' : 'bg-transparent border-transparent'"
         class="transition-all duration-500 border-b border-transparent"
         aria-label="Main navigation">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-slate-900 dark:text-white" aria-label="{{ setting('company_name', 'MinimalDigital') }} home">
                    <img src="{{ media_url(setting('logo', '/images/brand/logo.svg')) }}" alt="{{ setting('company_name', 'MinimalDigital') }} logo" class="h-8 w-auto">
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}#products" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Products</a>
                    <a href="{{ route('home') }}#mission" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Mission</a>
                    <a href="{{ route('home') }}#faq" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">FAQ</a>
                    <a href="{{ route('home') }}#contact" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Contact</a>
                </div>

                <div class="flex items-center gap-2">
                    @include('partials.theme-toggle')

                    <a href="{{ route('home') }}#contact" class="hidden sm:inline-flex btn-primary !px-5 !py-2.5">Get in touch</a>

                    <button @click="open = !open" class="md:hidden p-2 rounded-lg text-slate-600 dark:text-slate-300"
                            :aria-expanded="open" aria-controls="mobile-menu" aria-label="Toggle menu">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" x-cloak x-transition.opacity.duration.200ms id="mobile-menu" class="md:hidden px-4 pb-5 pt-1 space-y-1">
            @foreach(['products' => 'Products', 'mission' => 'Mission', 'faq' => 'FAQ', 'contact' => 'Contact'] as $anchor => $label)
                <a href="{{ route('home') }}#{{ $anchor }}" @click="open = false"
                   class="block rounded-xl px-4 py-3 text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-primary-50 dark:hover:bg-slate-800">{{ $label }}</a>
            @endforeach
        </div>
    </nav>
</header>
