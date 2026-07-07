@extends('layouts.site')

@section('seo_title', $product->seo_title ?: $product->name.' — '.setting('company_name', 'MinimalDigital'))
@section('seo_description', $product->seo_description ?: $product->short_description)
@section('seo_keywords', $product->seo_keywords)
@section('seo_image', url(media_url($product->cover_image)))

@section('structured_data')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'SoftwareApplication',
    'name' => $product->name,
    'description' => $product->short_description,
    'applicationCategory' => 'BusinessApplication',
    'operatingSystem' => 'Web',
    'url' => $product->website_url ?: url()->current(),
    'softwareVersion' => $product->version,
    'image' => url(media_url($product->cover_image)),
], JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Products', 'item' => url('/#products')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $product->name, 'item' => url()->current()],
    ],
], JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-[70svh] flex items-center overflow-hidden" style="--brand: {{ $product->color_theme ?? '#6366f1' }}">
        <img src="{{ media_url($product->hero_image ?: $product->cover_image) }}" alt="{{ $product->name }} hero"
             class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-slate-950/20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-28 w-full">
            <nav aria-label="Breadcrumb" class="mb-8">
                <ol class="flex items-center gap-2 text-sm text-white/60">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ route('home') }}#products" class="hover:text-white transition-colors">Products</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="text-white font-medium" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="max-w-2xl animate-fade-up">
                @if($product->logo)
                    <img src="{{ media_url($product->logo) }}" alt="{{ $product->name }} logo" class="h-16 w-16 rounded-2xl shadow-glow mb-6">
                @endif
                <h1 class="heading-xl !text-white">{{ $product->name }}</h1>
                <p class="mt-5 text-lg text-white/75 leading-relaxed">{{ $product->short_description }}</p>

                <div class="mt-6 flex flex-wrap gap-2">
                    @if($product->category)<span class="badge">{{ $product->category->name }}</span>@endif
                    @if($product->version)<span class="badge">v{{ $product->version }}</span>@endif
                    @if($product->platform)<span class="badge">{{ $product->platform }}</span>@endif
                </div>

                <div class="mt-9 flex flex-wrap gap-3">
                    @if($product->website_url)
                        <a href="{{ $product->website_url }}" target="_blank" rel="noopener" class="btn-primary">{{ $product->button_text ?: 'Visit Product' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        </a>
                    @endif
                    @if($product->demo_url && $product->demo_url !== $product->website_url)
                        <a href="{{ $product->demo_url }}" target="_blank" rel="noopener" class="btn-secondary !text-white">Live Demo</a>
                    @endif
                    @if($product->github_url)
                        <a href="{{ $product->github_url }}" target="_blank" rel="noopener" class="btn-secondary !text-white">GitHub</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Overview --}}
    <section class="py-20 sm:py-28" aria-labelledby="overview-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid gap-14 lg:grid-cols-5">
            <div class="lg:col-span-3 reveal">
                <span class="badge-soft">Overview</span>
                <h2 id="overview-heading" class="heading-lg mt-4">Everything you need, nothing you don't</h2>
                <div class="mt-6 space-y-4 text-base leading-7 text-slate-500 dark:text-slate-400">
                    @foreach(preg_split('/\r\n\r\n|\n\n/', (string) $product->long_description) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                @if($product->tech_stack)
                    <h3 class="mt-10 text-sm font-semibold uppercase tracking-wider text-slate-400">Technology stack</h3>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($product->tech_stack as $tech)
                            <span class="badge-soft">{{ $tech }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($product->features)
                <div class="lg:col-span-2">
                    <div class="card-premium p-8 lg:sticky lg:top-24 reveal">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Key features</h3>
                        <ul class="mt-5 space-y-3.5">
                            @foreach($product->features as $feature)
                                <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-300">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent-500/15 text-accent-500">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                    </span>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Animated statistics --}}
    @if($product->stats)
        <section class="py-16 bg-slate-50 dark:bg-slate-900/40" aria-label="{{ $product->name }} statistics">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid grid-cols-2 lg:grid-cols-4 gap-6" data-reveal-group>
                @foreach($product->stats as $stat)
                    <div class="reveal text-center p-6">
                        <p class="text-4xl font-extrabold" style="color: {{ $product->color_theme ?? '#6366f1' }}">{{ $stat['value'] ?? '' }}</p>
                        <p class="mt-1.5 text-sm font-medium text-slate-500 dark:text-slate-400">{{ $stat['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Gallery / screenshots --}}
    @if($product->images->isNotEmpty())
        <section class="py-20 sm:py-28" aria-labelledby="gallery-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center reveal">
                    <span class="badge-soft">Screenshots</span>
                    <h2 id="gallery-heading" class="heading-lg mt-4">See it in action</h2>
                </div>
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                    @foreach($product->images as $image)
                        <figure class="card-premium reveal overflow-hidden !p-0">
                            <img src="{{ media_url($image->path) }}" alt="{{ $image->alt ?: $product->name.' screenshot' }}" loading="lazy" class="w-full aspect-[8/5] object-cover">
                            @if($image->caption)<figcaption class="p-4 text-xs text-slate-400">{{ $image->caption }}</figcaption>@endif
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Video placeholder --}}
    <section class="py-20 sm:py-24" aria-label="Product video">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 reveal">
            <div class="relative aspect-video rounded-3xl overflow-hidden card-premium !p-0 group cursor-pointer"
                 role="button" tabindex="0" aria-label="Product walkthrough video coming soon">
                <img src="{{ media_url($product->cover_image) }}" alt="" aria-hidden="true" loading="lazy" class="absolute inset-0 h-full w-full object-cover opacity-60">
                <div class="absolute inset-0 bg-slate-950/40 flex flex-col items-center justify-center gap-4">
                    <span class="flex h-20 w-20 items-center justify-center rounded-full glass !bg-white/20 transition-transform duration-300 group-hover:scale-110">
                        <svg class="w-8 h-8 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.86l11-6.86a1 1 0 0 0 0-1.72l-11-6.86A1 1 0 0 0 8 5.14Z"/></svg>
                    </span>
                    <p class="text-sm font-medium text-white/80">Product walkthrough — coming soon</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    @if($product->faqs)
        <section class="py-20 sm:py-28 bg-slate-50 dark:bg-slate-900/40" aria-labelledby="product-faq-heading">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <div class="text-center reveal">
                    <span class="badge-soft">FAQ</span>
                    <h2 id="product-faq-heading" class="heading-lg mt-4">{{ $product->name }} questions</h2>
                </div>
                <div class="mt-12 space-y-4" data-reveal-group>
                    @foreach($product->faqs as $faq)
                        <details class="card-premium reveal group !rounded-2xl p-0 overflow-hidden">
                            <summary class="flex cursor-pointer items-center justify-between gap-4 px-6 py-5 text-base font-semibold text-slate-900 dark:text-white list-none [&::-webkit-details-marker]:hidden">
                                {{ $faq['question'] ?? '' }}
                                <svg class="w-5 h-5 shrink-0 text-slate-400 transition-transform duration-300 group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            </summary>
                            <p class="px-6 pb-6 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $faq['answer'] ?? '' }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA + brochure --}}
    <section class="relative py-24 overflow-hidden" aria-labelledby="cta-heading">
        <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $product->color_theme ?? '#6366f1' }}, #7c3aed)"></div>
        <div class="absolute inset-0 bg-grid opacity-30"></div>
        <div class="relative mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 text-center reveal">
            <h2 id="cta-heading" class="heading-lg !text-white">Ready to try {{ $product->name }}?</h2>
            <p class="mt-4 text-white/75">Explore the live product or talk to us about your needs.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                @if($product->website_url)
                    <a href="{{ $product->website_url }}" target="_blank" rel="noopener" class="btn-secondary !bg-white !text-slate-900 hover:!bg-white/90">{{ $product->button_text ?: 'Visit Product' }}</a>
                @endif
                <a href="{{ route('home') }}#contact" class="btn-secondary !text-white">Contact us</a>
                <button type="button" class="btn-ghost !text-white/70 hover:!text-white" title="Brochure coming soon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Download brochure (soon)
                </button>
            </div>
        </div>
    </section>

    {{-- Related products --}}
    @if($related->isNotEmpty())
        <section class="py-20 sm:py-28" aria-labelledby="related-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 id="related-heading" class="heading-lg reveal">More from {{ setting('company_name', 'MinimalDigital') }}</h2>
                <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                    @foreach($related as $rel)
                        <x-product-card :product="$rel" class="reveal" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
