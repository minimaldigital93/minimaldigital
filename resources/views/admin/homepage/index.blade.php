@extends('layouts.admin')

@section('title', 'Homepage Builder')

@section('content')
    <p class="text-sm text-slate-500 dark:text-slate-400">Drag sections to change their order on the homepage. Toggle a section off to hide it without deleting anything.</p>

    <ul class="mt-6 max-w-2xl space-y-3" data-sortable-url="{{ route('admin.homepage.reorder') }}">
        @foreach($sections as $section)
            <li data-id="{{ $section->id }}" class="card-premium !rounded-2xl p-4 flex items-center gap-4 {{ $section->is_active ? '' : 'opacity-60' }}">
                <button type="button" data-sort-handle class="cursor-grab active:cursor-grabbing p-2 text-slate-300 hover:text-slate-500" aria-label="Drag to reorder">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm9-14a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                </button>

                <div class="flex-1">
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $section->title }}</p>
                    <p class="text-xs text-slate-400">Key: {{ $section->key }}</p>
                </div>

                <span class="badge-soft {{ $section->is_active ? '!bg-emerald-50 !text-emerald-700 dark:!bg-emerald-950 dark:!text-emerald-300' : '' }}">
                    {{ $section->is_active ? 'Visible' : 'Hidden' }}
                </span>

                <form method="POST" action="{{ route('admin.homepage.toggle', $section) }}">
                    @csrf
                    <button type="submit" class="btn-ghost text-xs">{{ $section->is_active ? 'Hide' : 'Show' }}</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
