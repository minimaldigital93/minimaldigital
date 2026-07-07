@extends('layouts.admin')

@section('title', 'Website Settings')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf

        {{-- Brand images --}}
        <div class="card-premium p-6">
            <h2 class="text-base font-bold text-slate-900 dark:text-white">Brand</h2>
            <div class="mt-5 grid gap-6 sm:grid-cols-2">
                <div>
                    <x-input-label for="logo_file" value="Logo" />
                    <img src="{{ media_url($values['logo'] ?? '/images/brand/logo.svg') }}" alt="Current logo" class="mt-2 h-10 w-auto">
                    <input type="file" id="logo_file" name="logo_file" accept="image/*"
                           class="mt-3 block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary-700 dark:file:bg-primary-950 dark:file:text-primary-300">
                </div>
                <div>
                    <x-input-label for="favicon_file" value="Favicon" />
                    <img src="{{ media_url($values['favicon'] ?? '/images/brand/favicon.svg') }}" alt="Current favicon" class="mt-2 h-10 w-10 rounded-lg">
                    <input type="file" id="favicon_file" name="favicon_file" accept="image/*"
                           class="mt-3 block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary-700 dark:file:bg-primary-950 dark:file:text-primary-300">
                </div>
            </div>
        </div>

        {{-- Grouped text settings --}}
        @foreach($groups as $group => $fields)
            <div class="card-premium p-6">
                <h2 class="text-base font-bold text-slate-900 dark:text-white capitalize">{{ $group }}</h2>
                <div class="mt-5 grid gap-5 {{ count($fields) > 2 ? 'sm:grid-cols-2' : '' }}">
                    @foreach($fields as $key => $label)
                        <div @class(['sm:col-span-2' => in_array($key, ['mission', 'vision', 'footer_text', 'seo_description', 'analytics_code'])])>
                            <x-input-label :for="$key" :value="$label" />
                            @if(in_array($key, ['mission', 'vision', 'footer_text', 'seo_description', 'analytics_code']))
                                <textarea id="{{ $key }}" name="settings[{{ $key }}]" rows="{{ $key === 'analytics_code' ? 4 : 2 }}"
                                          class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('settings.'.$key, $values[$key] ?? '') }}</textarea>
                            @elseif(str_ends_with($key, '_color'))
                                <input type="color" id="{{ $key }}" name="settings[{{ $key }}]" value="{{ old('settings.'.$key, $values[$key] ?? '#6366f1') }}"
                                       class="mt-1.5 h-10 w-full rounded-xl border-slate-300 dark:border-slate-700 cursor-pointer">
                            @else
                                <x-text-input :id="$key" name="settings[{{ $key }}]" class="mt-1.5 block w-full"
                                              :value="old('settings.'.$key, $values[$key] ?? '')" />
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Save Settings</button>
        </div>
    </form>
@endsection
