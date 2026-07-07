@if($products->isNotEmpty())
<section id="products" class="relative py-24 sm:py-32 bg-grid" aria-labelledby="products-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl reveal">
            <span class="badge-soft">Our Products</span>
            <h2 id="products-heading" class="heading-lg mt-4">Software that feels <span class="text-gradient">effortless</span></h2>
            <p class="mt-4 text-lg text-slate-500 dark:text-slate-400">Purpose-built tools that help businesses run beautifully — minimal on the surface, powerful underneath.</p>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-2" data-reveal-group>
            @foreach($products as $product)
                <x-product-card :product="$product" class="reveal" />
            @endforeach
        </div>
    </div>
</section>
@endif
