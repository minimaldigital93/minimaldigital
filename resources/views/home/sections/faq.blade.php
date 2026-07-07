<section id="faq" class="py-24 sm:py-32 bg-slate-50 dark:bg-slate-900/40" aria-labelledby="faq-heading">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal">
            <span class="badge-soft">FAQ</span>
            <h2 id="faq-heading" class="heading-lg mt-4">Frequently asked questions</h2>
        </div>

        <div class="mt-12 space-y-4" data-reveal-group>
            @foreach([
                ['q' => 'What does MinimalDigital build?', 'a' => 'We build focused business software: AMS for apartment management and SmartSell for POS & inventory — with more products on the way.'],
                ['q' => 'Can I try the products before buying?', 'a' => 'Yes. Each product page links to a live demo so you can explore every feature before committing.'],
                ['q' => 'Do the products work on mobile?', 'a' => 'All our products are fully responsive and installable as PWAs, so they feel native on phones and tablets.'],
                ['q' => 'Do you support KHQR payments?', 'a' => 'SmartSell supports KHQR (Bakong) payments out of the box, alongside cash, with itemized receipts.'],
                ['q' => 'How do I get support?', 'a' => 'Reach us via email or Telegram — links are in the footer. We usually respond within one business day.'],
            ] as $faq)
                <details class="card-premium reveal group !rounded-2xl p-0 overflow-hidden">
                    <summary class="flex cursor-pointer items-center justify-between gap-4 px-6 py-5 text-base font-semibold text-slate-900 dark:text-white list-none [&::-webkit-details-marker]:hidden">
                        {{ $faq['q'] }}
                        <svg class="w-5 h-5 shrink-0 text-slate-400 transition-transform duration-300 group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </summary>
                    <p class="px-6 pb-6 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
