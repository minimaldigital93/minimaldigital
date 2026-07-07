<section class="py-24 sm:py-28" aria-labelledby="stats-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 id="stats-heading" class="sr-only">Company statistics</h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6" data-reveal-group>
            @foreach([
                ['count' => 2, 'suffix' => '+', 'label' => 'Products shipped'],
                ['count' => 500, 'suffix' => '+', 'label' => 'Rooms & shops served'],
                ['count' => 99, 'suffix' => '.9%', 'label' => 'Uptime'],
                ['count' => 24, 'suffix' => '/7', 'label' => 'Available anywhere'],
            ] as $stat)
                <div class="card-premium reveal p-8 text-center">
                    <p class="text-4xl sm:text-5xl font-extrabold text-gradient" data-count="{{ $stat['count'] }}" data-count-suffix="{{ $stat['suffix'] }}">0{{ $stat['suffix'] }}</p>
                    <p class="mt-2 text-sm font-medium text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
