@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
    {{-- Upload dropzone --}}
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <div data-dropzone
             class="card-premium border-2 border-dashed !border-slate-300 dark:!border-slate-700 p-10 text-center cursor-pointer transition-all hover:!border-primary-400">
            <svg class="mx-auto w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
            <p class="mt-3 text-sm font-semibold text-slate-700 dark:text-slate-300">Drag & drop images here, or click to browse</p>
            <p class="mt-1 text-xs text-slate-400">JPEG, PNG, WebP, SVG or GIF · up to 8 MB · multiple files supported</p>

            <label class="mt-4 inline-block">
                <span class="btn-secondary !py-2.5 cursor-pointer">Choose files</span>
                <input type="file" name="files[]" accept="image/*" multiple class="sr-only">
            </label>

            <div class="mt-4 flex justify-center">
                <select name="folder" class="rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500"
                        onclick="event.stopPropagation()">
                    <option value="general">Folder: general</option>
                    @foreach($folders as $folder)
                        @if($folder !== 'general')<option value="{{ $folder }}">Folder: {{ $folder }}</option>@endif
                    @endforeach
                    <option value="products">Folder: products</option>
                    <option value="slides">Folder: slides</option>
                    <option value="brand">Folder: brand</option>
                </select>
            </div>
        </div>
    </form>

    {{-- Filters --}}
    <form method="GET" class="mt-6 flex flex-wrap gap-2">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search media…"
               class="rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
        <select name="folder" onchange="this.form.submit()"
                class="rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
            <option value="">All folders</option>
            @foreach($folders as $folder)
                <option value="{{ $folder }}" @selected(request('folder') === $folder)>{{ $folder }}</option>
            @endforeach
        </select>
    </form>

    {{-- Grid --}}
    @if($items->isEmpty())
        <div class="mt-10 text-center text-slate-400">No media found.</div>
    @else
        <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach($items as $item)
                <div class="card-premium !rounded-2xl overflow-hidden !p-0 group" x-data="{ editing: false }">
                    <div class="relative aspect-square bg-slate-100 dark:bg-slate-800">
                        <img src="{{ $item->url }}" alt="{{ $item->alt ?: $item->name }}" loading="lazy" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <a href="{{ $item->url }}" target="_blank" class="p-2 rounded-full bg-white/20 text-white hover:bg-white/40" aria-label="Preview">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1.01 1.01 0 0 1 0-.64C3.42 7.51 7.36 4.5 12 4.5s8.58 3.01 9.96 7.18c.07.21.07.43 0 .64C20.58 16.49 16.64 19.5 12 19.5s-8.58-3.01-9.96-7.18Z M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </a>
                            <button @click="editing = !editing" class="p-2 rounded-full bg-white/20 text-white hover:bg-white/40" aria-label="Edit / replace">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m16.86 4.49 1.68-1.69a1.88 1.88 0 1 1 2.65 2.65L7.12 19.51a4.5 4.5 0 0 1-1.9 1.13L2.6 21.4l.76-2.62a4.5 4.5 0 0 1 1.13-1.9L16.86 4.49Zm0 0L19.5 7.13"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.media.destroy', $item) }}"
                                  onsubmit="return confirm('Delete {{ $item->file_name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-full bg-rose-500/80 text-white hover:bg-rose-500" aria-label="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.35 9m-4.78 0L9.26 9m9.97-3.21c.34.05.68.11 1.02.17m-1.02-.17-1.06 13.8A2.25 2.25 0 0 1 15.92 21H8.08a2.25 2.25 0 0 1-2.24-2.08L4.77 5.79m14.46 0a48.1 48.1 0 0 0-3.48-.4m-12 .56c.34-.06.68-.12 1.02-.17m1.02-.17-.11-.02a48.1 48.1 0 0 1 3.48-.4m6.14 0a48.77 48.77 0 0 0-6.14 0m6.14 0V4.5A2.25 2.25 0 0 0 15.14 2.25h-2.28A2.25 2.25 0 0 0 10.61 4.5v.86"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 truncate" title="{{ $item->file_name }}">{{ $item->file_name }}</p>
                        <p class="text-[11px] text-slate-400">{{ $item->folder }} · {{ $item->human_size }}@if($item->width) · {{ $item->width }}×{{ $item->height }}@endif</p>
                    </div>
                    <form method="POST" action="{{ route('admin.media.update', $item) }}" enctype="multipart/form-data"
                          x-show="editing" x-cloak class="p-3 pt-0 space-y-2">
                        @csrf @method('PUT')
                        <input type="text" name="alt" value="{{ $item->alt }}" placeholder="Alt text"
                               class="block w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs focus:ring-primary-500 focus:border-primary-500">
                        <input type="file" name="file" accept="image/*"
                               class="block w-full text-[11px] text-slate-500 file:mr-2 file:rounded file:border-0 file:bg-primary-50 file:px-2 file:py-1 file:text-[11px] file:font-semibold file:text-primary-700 dark:file:bg-primary-950 dark:file:text-primary-300">
                        <button type="submit" class="w-full rounded-lg bg-primary-600 text-white text-xs font-semibold py-1.5 hover:bg-primary-700 transition-colors">Save / Replace</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $items->links() }}</div>
    @endif
@endsection
