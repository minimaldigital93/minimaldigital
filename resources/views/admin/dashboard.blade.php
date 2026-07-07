@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Stat cards --}}
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5">
        @foreach([
            ['label' => 'Total Products', 'value' => $stats['total_products'], 'color' => 'from-primary-500 to-purple-500', 'icon' => 'm21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
            ['label' => 'Published', 'value' => $stats['published_products'], 'color' => 'from-emerald-500 to-teal-500', 'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            ['label' => 'Hidden / Draft', 'value' => $stats['hidden_products'], 'color' => 'from-amber-500 to-orange-500', 'icon' => 'M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88'],
            ['label' => 'Slides', 'value' => $stats['slides'].' ('.$stats['active_slides'].' live)', 'color' => 'from-sky-500 to-blue-500', 'icon' => 'M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125Z'],
            ['label' => 'Visitors (soon)', 'value' => '—', 'color' => 'from-fuchsia-500 to-pink-500', 'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z'],
        ] as $card)
            <div class="card-premium p-6">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br {{ $card['color'] }} text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/></svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-extrabold text-slate-900 dark:text-white">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('admin.products.create') }}" class="btn-primary !py-2.5">+ New Product</a>
        <a href="{{ route('admin.slides.create') }}" class="btn-secondary !py-2.5">+ New Slide</a>
        <a href="{{ route('admin.media.index') }}" class="btn-secondary !py-2.5">Upload Media</a>
        <a href="{{ route('admin.settings.edit') }}" class="btn-secondary !py-2.5">Edit Settings</a>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        {{-- Latest products --}}
        <div class="card-premium p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Latest Products</h2>
                <a href="{{ route('admin.products.index') }}" class="btn-ghost text-xs">View all</a>
            </div>
            <ul class="mt-4 divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($latestProducts as $product)
                    <li class="flex items-center gap-4 py-3.5">
                        <img src="{{ media_url($product->logo) }}" alt="" class="h-10 w-10 rounded-xl object-cover bg-slate-100 dark:bg-slate-800">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $product->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $product->short_description }}</p>
                        </div>
                        <span class="badge-soft {{ $product->status === 'published' ? '!bg-emerald-50 !text-emerald-700 dark:!bg-emerald-950 dark:!text-emerald-300' : '' }}">{{ ucfirst($product->status) }}</span>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-ghost text-xs">Edit</a>
                    </li>
                @empty
                    <li class="py-6 text-sm text-slate-400 text-center">No products yet.</li>
                @endforelse
            </ul>
        </div>

        {{-- Recent uploads --}}
        <div class="card-premium p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Recent Uploads</h2>
                <a href="{{ route('admin.media.index') }}" class="btn-ghost text-xs">Media library</a>
            </div>
            @if($recentUploads->isEmpty())
                <p class="mt-6 text-sm text-slate-400 text-center">Nothing uploaded yet.</p>
            @else
                <div class="mt-4 grid grid-cols-4 gap-3">
                    @foreach($recentUploads as $upload)
                        <img src="{{ $upload->url }}" alt="{{ $upload->alt ?: $upload->name }}"
                             class="aspect-square w-full rounded-xl object-cover bg-slate-100 dark:bg-slate-800" loading="lazy">
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
