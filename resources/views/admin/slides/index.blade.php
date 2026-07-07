@extends('layouts.admin')

@section('title', 'Slideshow Manager')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-slate-500 dark:text-slate-400">Drag slides to reorder — the homepage updates instantly.</p>
        <a href="{{ route('admin.slides.create') }}" class="btn-primary !py-2.5">+ New Slide</a>
    </div>

    {{-- Global slideshow settings --}}
    <form method="POST" action="{{ route('admin.slides.settings') }}" class="mt-6 card-premium p-6">
        @csrf
        <h2 class="text-base font-bold text-slate-900 dark:text-white">Slideshow Settings</h2>
        <div class="mt-4 flex flex-wrap items-end gap-4">
            <div>
                <x-input-label for="slideshow_autoplay_delay" value="Autoplay speed (ms)" />
                <x-text-input id="slideshow_autoplay_delay" name="slideshow_autoplay_delay" type="number" min="2000" max="20000" step="500"
                              class="mt-1.5 block w-40" :value="$autoplayDelay" />
            </div>
            <div>
                <x-input-label for="slideshow_transition_duration" value="Transition duration (ms)" />
                <x-text-input id="slideshow_transition_duration" name="slideshow_transition_duration" type="number" min="200" max="3000" step="100"
                              class="mt-1.5 block w-40" :value="$transitionDuration" />
            </div>
            <button type="submit" class="btn-secondary !py-2.5">Save Settings</button>
        </div>
    </form>

    {{-- Sortable slide list --}}
    <ul class="mt-6 space-y-3" data-sortable-url="{{ route('admin.slides.reorder') }}">
        @forelse($slides as $slide)
            <li data-id="{{ $slide->id }}" class="card-premium !rounded-2xl p-4 flex items-center gap-4 {{ $slide->is_active ? '' : 'opacity-60' }}">
                <button type="button" data-sort-handle class="cursor-grab active:cursor-grabbing p-2 text-slate-300 hover:text-slate-500" aria-label="Drag to reorder">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9-14a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                </button>

                <img src="{{ media_url($slide->image) }}" alt="" class="h-16 w-28 rounded-xl object-cover bg-slate-100 dark:bg-slate-800">

                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-slate-900 dark:text-white truncate">{{ $slide->title }}
                        <span class="font-normal text-slate-400">{{ $slide->subtitle }}</span>
                    </p>
                    <p class="text-xs text-slate-400 truncate">
                        {{ $slide->product?->name ? 'Product: '.$slide->product->name.' · ' : '' }}Animation: {{ ucfirst($slide->animation) }}
                    </p>
                </div>

                <span class="badge-soft {{ $slide->is_active ? '!bg-emerald-50 !text-emerald-700 dark:!bg-emerald-950 dark:!text-emerald-300' : '' }}">
                    {{ $slide->is_active ? 'Active' : 'Disabled' }}
                </span>

                <div class="flex gap-1.5">
                    <form method="POST" action="{{ route('admin.slides.toggle', $slide) }}">
                        @csrf
                        <button type="submit" class="btn-ghost text-xs">{{ $slide->is_active ? 'Disable' : 'Enable' }}</button>
                    </form>
                    <a href="{{ route('admin.slides.edit', $slide) }}" class="btn-ghost text-xs">Edit</a>
                    <form method="POST" action="{{ route('admin.slides.destroy', $slide) }}"
                          onsubmit="return confirm('Delete this slide?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-ghost text-xs !text-rose-500 hover:!text-rose-600">Delete</button>
                    </form>
                </div>
            </li>
        @empty
            <li class="card-premium p-12 text-center text-slate-400">No slides yet — create the first one.</li>
        @endforelse
    </ul>

    <p class="mt-6 text-xs text-slate-400">Tip: preview your changes on the <a href="{{ route('home') }}" target="_blank" class="text-primary-500 hover:underline">live homepage</a> before sharing.</p>
@endsection
