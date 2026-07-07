<section id="mission" class="relative py-24 sm:py-32 overflow-hidden" aria-labelledby="mission-heading">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-purple-800"></div>
    <div class="absolute inset-0 bg-grid opacity-40"></div>
    <div class="pointer-events-none absolute -top-32 -left-32 w-96 h-96 rounded-full bg-white/10 blur-3xl" data-parallax="30"></div>
    <div class="pointer-events-none absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-accent-500/20 blur-3xl" data-parallax="50"></div>

    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 text-center">
        <h2 id="mission-heading" class="sr-only">Mission and vision</h2>

        <div class="grid gap-8 md:grid-cols-2" data-reveal-group>
            <div class="glass !bg-white/10 !border-white/20 rounded-3xl p-8 sm:p-10 text-left reveal">
                <span class="badge">Our Mission</span>
                <p class="mt-5 text-xl sm:text-2xl font-semibold leading-relaxed text-white">{{ setting('mission') }}</p>
            </div>
            <div class="glass !bg-white/10 !border-white/20 rounded-3xl p-8 sm:p-10 text-left reveal">
                <span class="badge">Our Vision</span>
                <p class="mt-5 text-xl sm:text-2xl font-semibold leading-relaxed text-white">{{ setting('vision') }}</p>
            </div>
        </div>
    </div>
</section>
