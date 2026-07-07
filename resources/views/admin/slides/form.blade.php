@extends('layouts.admin')

@section('title', $slide->exists ? 'Edit Slide' : 'New Slide')

@section('content')
    <form method="POST" enctype="multipart/form-data"
          action="{{ $slide->exists ? route('admin.slides.update', $slide) : route('admin.slides.store') }}"
          class="grid gap-6 xl:grid-cols-3">
        @csrf
        @if($slide->exists) @method('PUT') @endif

        <div class="xl:col-span-2 space-y-6">
            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Content</h2>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-input-label for="title" value="Title *" />
                        <x-text-input id="title" name="title" class="mt-1.5 block w-full" :value="old('title', $slide->title)" required />
                    </div>
                    <div>
                        <x-input-label for="subtitle" value="Subtitle" />
                        <x-text-input id="subtitle" name="subtitle" class="mt-1.5 block w-full" :value="old('subtitle', $slide->subtitle)" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="3" maxlength="1000"
                              class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('description', $slide->description) }}</textarea>
                </div>

                <div>
                    <x-input-label for="badges" value="Feature Badges (comma separated)" />
                    <x-text-input id="badges" name="badges" class="mt-1.5 block w-full"
                                  :value="old('badges', implode(', ', $slide->badges ?? []))" placeholder="Inventory, POS, Barcode" />
                </div>
            </div>

            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Images</h2>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-input-label for="image_file" value="Background Image" />
                        @if($slide->image)
                            <img src="{{ media_url($slide->image) }}" alt="" class="mt-2 h-28 w-full rounded-xl object-cover bg-slate-100 dark:bg-slate-800">
                        @endif
                        <input type="file" id="image_file" name="image_file" accept="image/*"
                               class="mt-2 block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary-700 dark:file:bg-primary-950 dark:file:text-primary-300 hover:file:bg-primary-100">
                    </div>
                    <div>
                        <x-input-label for="logo_file" value="Product Logo" />
                        @if($slide->logo)
                            <img src="{{ media_url($slide->logo) }}" alt="" class="mt-2 h-16 w-16 rounded-xl object-cover bg-slate-100 dark:bg-slate-800">
                        @endif
                        <input type="file" id="logo_file" name="logo_file" accept="image/*"
                               class="mt-2 block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary-700 dark:file:bg-primary-950 dark:file:text-primary-300 hover:file:bg-primary-100">
                    </div>
                </div>
            </div>

            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Call-to-Action Buttons</h2>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-input-label for="cta_primary_text" value="Primary Button Text" />
                        <x-text-input id="cta_primary_text" name="cta_primary_text" class="mt-1.5 block w-full" :value="old('cta_primary_text', $slide->cta_primary_text)" placeholder="Learn More" />
                    </div>
                    <div>
                        <x-input-label for="cta_primary_url" value="Primary Button URL" />
                        <x-text-input id="cta_primary_url" name="cta_primary_url" class="mt-1.5 block w-full" :value="old('cta_primary_url', $slide->cta_primary_url)" placeholder="/products/ams" />
                    </div>
                    <div>
                        <x-input-label for="cta_secondary_text" value="Secondary Button Text" />
                        <x-text-input id="cta_secondary_text" name="cta_secondary_text" class="mt-1.5 block w-full" :value="old('cta_secondary_text', $slide->cta_secondary_text)" placeholder="Visit Product" />
                    </div>
                    <div>
                        <x-input-label for="cta_secondary_url" value="Secondary Button URL" />
                        <x-text-input id="cta_secondary_url" name="cta_secondary_url" class="mt-1.5 block w-full" :value="old('cta_secondary_url', $slide->cta_secondary_url)" />
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Options</h2>

                <div>
                    <x-input-label for="product_id" value="Attached Product" />
                    <select id="product_id" name="product_id" class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">— None —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id', $slide->product_id) == $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="animation" value="Animation *" />
                    <select id="animation" name="animation" class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                        @foreach(['fade' => 'Fade', 'zoom' => 'Zoom', 'parallax' => 'Parallax', 'blur' => 'Blur'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('animation', $slide->animation) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="color_theme" value="Accent Color" />
                    <input type="color" id="color_theme" name="color_theme" value="{{ old('color_theme', $slide->color_theme ?? '#6366f1') }}"
                           class="mt-1.5 h-10 w-full rounded-xl border-slate-300 dark:border-slate-700 cursor-pointer">
                </div>

                <div>
                    <x-input-label for="display_order" value="Display Order" />
                    <x-text-input id="display_order" name="display_order" type="number" min="0" class="mt-1.5 block w-full"
                                  :value="old('display_order', $slide->display_order ?? 0)" />
                </div>

                <label class="flex items-center gap-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide->is_active))
                           class="rounded border-slate-300 dark:border-slate-700 text-primary-600 focus:ring-primary-500">
                    Active (visible on homepage)
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1">{{ $slide->exists ? 'Save Changes' : 'Create Slide' }}</button>
                <a href="{{ route('admin.slides.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
@endsection
