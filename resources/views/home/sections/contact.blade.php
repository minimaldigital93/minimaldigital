<section id="contact" class="relative py-24 sm:py-32 overflow-hidden" aria-labelledby="contact-heading">
    <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] rounded-full bg-primary-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center reveal">
        <span class="badge-soft">Contact</span>
        <h2 id="contact-heading" class="heading-lg mt-4">Let's build something <span class="text-gradient">great together</span></h2>
        <p class="mt-4 text-lg text-slate-500 dark:text-slate-400 max-w-xl mx-auto">Questions about our products, custom builds or partnerships? We'd love to hear from you.</p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            @if(setting('email'))
                <a href="mailto:{{ setting('email') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.24a2.25 2.25 0 0 1-1.07 1.92l-7.5 4.61a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.92v-.24"/></svg>
                    {{ setting('email') }}
                </a>
            @endif
            @if(setting('telegram'))
                <a href="{{ setting('telegram') }}" target="_blank" rel="noopener" class="btn-secondary">Message on Telegram</a>
            @endif
        </div>

        @if(setting('phone') || setting('address'))
            <p class="mt-8 text-sm text-slate-400 dark:text-slate-500">
                {{ setting('phone') }} @if(setting('phone') && setting('address')) · @endif {{ setting('address') }}
            </p>
        @endif
    </div>
</section>
