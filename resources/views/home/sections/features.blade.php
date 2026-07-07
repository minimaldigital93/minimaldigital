<section class="py-24 sm:py-32" aria-labelledby="features-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center reveal">
            <span class="badge-soft">Why {{ setting('company_name', 'MinimalDigital') }}</span>
            <h2 id="features-heading" class="heading-lg mt-4">Minimal design. <span class="text-gradient">Maximum impact.</span></h2>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach([
                ['title' => 'Built for speed', 'body' => 'Every screen is optimized to load fast and respond instantly — no waiting, no clutter.', 'icon' => 'M3.75 13.5 14.25 2.25 12 10.5h8.25L9.75 21.75 12 13.5H3.75Z'],
                ['title' => 'Beautifully minimal', 'body' => 'Interfaces reduced to the essentials, so your team can focus on the work that matters.', 'icon' => 'M9.53 16.12 4.6 11.2a2.1 2.1 0 0 1 0-2.97l4.24-4.25a2.1 2.1 0 0 1 2.97 0l4.93 4.93M14.74 9.4l4.66 4.65a2.1 2.1 0 0 1 0 2.97l-4.24 4.25a2.1 2.1 0 0 1-2.97 0L7.53 16.6'],
                ['title' => 'Secure by default', 'body' => 'Authentication, validation and encrypted storage are built into every product we ship.', 'icon' => 'M9 12.75 11.25 15 15 9.75m-3-7.03a11.96 11.96 0 0 1-8.62 3.04 12.08 12.08 0 0 0-.66 3.99c0 5.59 3.82 10.29 9 11.62 5.18-1.33 9-6.03 9-11.62 0-1.4-.23-2.73-.66-3.99A11.96 11.96 0 0 1 12 2.72Z'],
                ['title' => 'Works everywhere', 'body' => 'Desktop, tablet, phone or installed as a PWA — one experience, every device.', 'icon' => 'M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3'],
                ['title' => 'Real analytics', 'body' => 'Dashboards and reports that turn day-to-day activity into decisions you can act on.', 'icon' => 'M3 13.13 8.62 7.5l4.13 4.13 7.5-7.51M21 4.13v6h-6'],
                ['title' => 'Local support', 'body' => 'Built in Cambodia with KHQR payments and local business workflows as first-class features.', 'icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm4.5 0c0 7.14-7.5 11.25-7.5 11.25S4.5 17.64 4.5 10.5a7.5 7.5 0 1 1 15 0Z'],
            ] as $feature)
                <div class="card-premium reveal p-7">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-purple-500 flex items-center justify-center shadow-glow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $feature['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
