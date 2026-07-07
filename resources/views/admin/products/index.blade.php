@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="flex flex-wrap items-center gap-3 justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search products…"
                   class="rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
            <select name="status" onchange="this.form.submit()"
                    class="rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                <option value="">All statuses</option>
                @foreach(['published', 'draft', 'hidden'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn-primary !py-2.5">+ New Product</a>
    </div>

    <div class="mt-6 card-premium overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 text-left text-xs uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-4 font-semibold">Product</th>
                        <th class="px-6 py-4 font-semibold">Category</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Featured</th>
                        <th class="px-6 py-4 font-semibold">Order</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ media_url($product->logo) }}" alt="" class="h-10 w-10 rounded-xl object-cover bg-slate-100 dark:bg-slate-800">
                                    <div>
                                        <p class="font-semibold text-slate-900 dark:text-white">{{ $product->name }}</p>
                                        <p class="text-xs text-slate-400">/products/{{ $product->slug }} @if($product->version) · v{{ $product->version }} @endif</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="badge-soft {{ $product->status === 'published' ? '!bg-emerald-50 !text-emerald-700 dark:!bg-emerald-950 dark:!text-emerald-300' : ($product->status === 'hidden' ? '!bg-slate-100 !text-slate-500 dark:!bg-slate-800 dark:!text-slate-400' : '!bg-amber-50 !text-amber-700 dark:!bg-amber-950 dark:!text-amber-300') }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $product->featured ? '★' : '—' }}</td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $product->display_order }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-1.5">
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn-ghost text-xs">View</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-ghost text-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Delete {{ $product->name }}? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-ghost text-xs !text-rose-500 hover:!text-rose-600">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection
