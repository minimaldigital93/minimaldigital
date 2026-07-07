<footer class="relative border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <img src="{{ media_url(setting('logo', '/images/brand/logo.svg')) }}" alt="{{ setting('company_name', 'MinimalDigital') }} logo" class="h-8 w-auto text-slate-900 dark:text-white">
                <p class="mt-4 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">{{ setting('footer_text') }}</p>

                <div class="mt-5 flex gap-3">
                    @foreach([
                        'facebook' => 'M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14C17.17 2.1 15.95 2 14.66 2 11.97 2 10 3.66 10 6.7v2.8H7v4h3V22h4v-8.5Z',
                        'telegram' => 'm21.9 4.4-3 14.2c-.2 1-.8 1.2-1.6.8l-4.6-3.4-2.2 2.1c-.2.3-.4.5-.9.5l.3-4.7 8.5-7.7c.4-.3-.1-.5-.6-.2L7.3 12.6 2.7 11.2c-1-.3-1-1 .2-1.5l17.7-6.8c.8-.3 1.5.2 1.3 1.5Z',
                        'github' => 'M12 2C6.5 2 2 6.6 2 12.2c0 4.5 2.9 8.3 6.8 9.7.5.1.7-.2.7-.5v-1.8c-2.8.6-3.4-1.2-3.4-1.2-.4-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.6 2.4 1.1 3 .9.1-.7.4-1.1.6-1.4-2.2-.3-4.6-1.1-4.6-5a4 4 0 0 1 1-2.7 3.7 3.7 0 0 1 .1-2.7s.9-.3 2.8 1a9.4 9.4 0 0 1 5 0c1.9-1.3 2.7-1 2.7-1 .6 1.4.2 2.4.1 2.7a4 4 0 0 1 1 2.7c0 4-2.4 4.7-4.6 5 .4.3.7.9.7 1.9v2.8c0 .3.2.6.7.5a10.2 10.2 0 0 0 6.8-9.7C22 6.6 17.5 2 12 2Z',
                        'linkedin' => 'M6.5 8.5H3V21h3.5V8.5ZM4.7 7A2.1 2.1 0 1 0 4.8 3a2.1 2.1 0 0 0 0 4.2ZM21 13.9c0-3.3-1.8-5-4.2-5-2 0-2.8 1.1-3.3 1.9V8.5H10V21h3.5v-6.6c0-1.7.4-3 2.2-3s1.8 1.6 1.8 3.1V21H21v-7.1Z',
                        'youtube' => 'M23 12s0-3.5-.5-5a3 3 0 0 0-2-2C18.9 4.5 12 4.5 12 4.5s-6.9 0-8.5.5a3 3 0 0 0-2 2C1 8.5 1 12 1 12s0 3.5.5 5a3 3 0 0 0 2 2c1.6.5 8.5.5 8.5.5s6.9 0 8.5-.5a3 3 0 0 0 2-2c.5-1.5.5-5 .5-5Zm-13 3.3V8.7l6 3.3-6 3.3Z',
                        'instagram' => 'M12 2.2c3.2 0 3.6 0 4.9.1 3.2.1 4.7 1.7 4.8 4.8.1 1.3.1 1.6.1 4.9s0 3.6-.1 4.9c-.1 3.1-1.6 4.7-4.8 4.8-1.3.1-1.6.1-4.9.1s-3.6 0-4.9-.1c-3.2-.1-4.7-1.7-4.8-4.8C2.2 15.6 2.2 15.3 2.2 12s0-3.6.1-4.9C2.4 4 4 2.4 7.1 2.3 8.4 2.2 8.8 2.2 12 2.2Zm0 4.6a5.1 5.1 0 1 0 0 10.3 5.1 5.1 0 0 0 0-10.3Zm0 8.5a3.3 3.3 0 1 1 0-6.7 3.3 3.3 0 0 1 0 6.7Zm5.3-8.7a1.2 1.2 0 1 0 0-2.4 1.2 1.2 0 0 0 0 2.4Z',
                    ] as $key => $iconPath)
                        @if(setting($key))
                            <a href="{{ setting($key) }}" target="_blank" rel="noopener"
                               class="p-2 rounded-lg text-slate-400 hover:text-primary-500 hover:bg-white dark:hover:bg-slate-800 transition-all"
                               aria-label="{{ ucfirst($key) }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="{{ $iconPath }}"/></svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Products</h3>
                <ul class="mt-4 space-y-2.5">
                    @foreach(\App\Models\Product::published()->ordered()->take(6)->get(['name', 'slug']) as $p)
                        <li><a href="{{ route('products.show', $p->slug) }}" class="text-sm text-slate-500 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{ $p->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Contact</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-slate-500 dark:text-slate-400">
                    @if(setting('email'))<li><a href="mailto:{{ setting('email') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{ setting('email') }}</a></li>@endif
                    @if(setting('phone'))<li><a href="tel:{{ preg_replace('/\s+/', '', setting('phone')) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{ setting('phone') }}</a></li>@endif
                    @if(setting('address'))<li>{{ setting('address') }}</li>@endif
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-slate-400 dark:text-slate-500">{{ setting('copyright') }}</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">{{ setting('tagline') }}</p>
        </div>
    </div>
</footer>
