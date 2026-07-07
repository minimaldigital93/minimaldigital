@if($slides->isNotEmpty())
<section class="relative h-[100svh] min-h-[560px] max-h-[980px]" aria-label="Featured products">
    <div class="hero-swiper swiper h-full"
         data-autoplay="{{ setting('slideshow_autoplay', '1') }}"
         data-autoplay-delay="{{ setting('slideshow_autoplay_delay', '6000') }}"
         data-transition-duration="{{ setting('slideshow_transition_duration', '900') }}">

        <div class="swiper-wrapper">
            @foreach($slides as $slide)
                <div class="swiper-slide relative overflow-hidden anim-{{ $slide->animation }}">
                    {{-- Background image with cinematic motion --}}
                    <img src="{{ media_url($slide->image) }}"
                         alt="{{ $slide->title }} background"
                         class="hero-slide-media anim-{{ $slide->animation }} absolute inset-0 h-full w-full object-cover"
                         @if(!$loop->first) loading="lazy" @endif>

                    {{-- Readability overlays --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-950/40 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-slate-950/30"></div>

                    {{-- Floating decorations --}}
                    <div class="pointer-events-none absolute -top-20 -right-20 w-96 h-96 rounded-full blur-3xl animate-pulse-glow"
                         style="background: radial-gradient({{ $slide->color_theme ?? '#6366f1' }}44, transparent 70%)"></div>
                    <div class="pointer-events-none absolute bottom-10 right-1/4 w-3 h-3 rounded-full bg-white/40 animate-float"></div>
                    <div class="pointer-events-none absolute top-1/3 right-12 w-2 h-2 rounded-full bg-white/30 animate-float-slow"></div>
                    <div class="pointer-events-none absolute top-24 left-1/2 w-2.5 h-2.5 rounded-full bg-white/25 animate-float"></div>

                    {{-- Content --}}
                    <div class="relative z-10 h-full mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center">
                        <div class="hero-slide-content max-w-2xl pt-16">
                            @if($slide->logo)
                                <img src="{{ media_url($slide->logo) }}" alt="{{ $slide->title }} logo"
                                     class="h-16 w-16 rounded-2xl shadow-glow mb-6">
                            @endif

                            <h1 class="heading-xl !text-white">
                                {{ $slide->title }}
                                @if($slide->subtitle)
                                    <span class="block mt-2 text-2xl sm:text-3xl lg:text-4xl font-semibold text-white/80">{{ $slide->subtitle }}</span>
                                @endif
                            </h1>

                            @if($slide->description)
                                <p class="mt-5 text-base sm:text-lg leading-relaxed text-white/70 max-w-xl">{{ $slide->description }}</p>
                            @endif

                            @if($slide->badges)
                                <div class="mt-6 flex flex-wrap gap-2">
                                    @foreach($slide->badges as $badge)
                                        <span class="badge">{{ $badge }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-8 flex flex-wrap gap-3">
                                @if($slide->cta_primary_text)
                                    <a href="{{ $slide->cta_primary_url }}" class="btn-primary">
                                        {{ $slide->cta_primary_text }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/></svg>
                                    </a>
                                @endif
                                @if($slide->cta_secondary_text)
                                    <a href="{{ $slide->cta_secondary_url }}" class="btn-secondary !text-white"
                                       @if(str_starts_with($slide->cta_secondary_url ?? '', 'http')) target="_blank" rel="noopener" @endif>
                                        {{ $slide->cta_secondary_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Controls --}}
        <div class="absolute bottom-8 inset-x-0 z-20 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="hero-swiper-pagination !relative !w-auto flex gap-1.5"></div>
            <div class="flex gap-2">
                <button class="hero-swiper-prev p-3 rounded-full glass !bg-white/10 text-white hover:!bg-white/25 transition-all" aria-label="Previous slide">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                </button>
                <button class="hero-swiper-next p-3 rounded-full glass !bg-white/10 text-white hover:!bg-white/25 transition-all" aria-label="Next slide">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Scroll hint --}}
    <a href="#products" class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 hidden lg:flex flex-col items-center text-white/50 hover:text-white transition-colors" aria-label="Scroll to products">
        <svg class="w-5 h-5 animate-float" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25 12 15.75 4.5 8.25"/></svg>
    </a>
</section>
@endif
