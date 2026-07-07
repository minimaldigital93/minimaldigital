@props(['product'])

<article {{ $attributes->merge(['class' => 'card-premium group overflow-hidden']) }}>
    {{-- Cover --}}
    <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-[8/5] overflow-hidden" aria-label="{{ $product->name }} details">
        <img src="{{ media_url($product->cover_image) }}"
             alt="{{ $product->name }} preview"
             loading="lazy"
             class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.06]">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

        @if($product->featured)
            <span class="absolute top-4 right-4 badge !bg-amber-400/90 !text-amber-950 !border-amber-300">★ Featured</span>
        @endif
    </a>

    <div class="p-7">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-3.5">
                @if($product->logo)
                    <img src="{{ media_url($product->logo) }}" alt="{{ $product->name }} logo" loading="lazy"
                         class="h-12 w-12 rounded-xl shadow-card transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                @endif
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $product->name }}</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500">
                        {{ $product->category?->name }}
                        @if($product->version) · v{{ $product->version }} @endif
                        @if($product->platform) · {{ $product->platform }} @endif
                    </p>
                </div>
            </div>
            <span class="shrink-0 badge-soft {{ $product->status === 'published' ? '!bg-emerald-50 !text-emerald-700 dark:!bg-emerald-950 dark:!text-emerald-300 !border-emerald-100 dark:!border-emerald-900' : '' }}">
                {{ $product->status === 'published' ? 'Live' : ucfirst($product->status) }}
            </span>
        </div>

        <p class="mt-4 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $product->short_description }}</p>

        @if($product->features)
            <ul class="mt-5 grid grid-cols-2 gap-x-4 gap-y-2">
                @foreach(array_slice($product->features, 0, 6) as $feature)
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                        <svg class="w-3.5 h-3.5 shrink-0 text-accent-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>
        @endif

        @if($product->tags->isNotEmpty())
            <div class="mt-5 flex flex-wrap gap-1.5">
                @foreach($product->tags as $tag)
                    <span class="rounded-md bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[11px] font-medium text-slate-500 dark:text-slate-400">#{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="mt-7 flex flex-wrap items-center gap-3">
            <a href="{{ route('products.show', $product->slug) }}" class="btn-primary !px-5 !py-2.5">Learn More</a>
            @if($product->website_url)
                <a href="{{ $product->website_url }}" target="_blank" rel="noopener" class="btn-ghost">
                    {{ $product->button_text ?: 'Visit Website' }}
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                </a>
            @endif
        </div>
    </div>
</article>
