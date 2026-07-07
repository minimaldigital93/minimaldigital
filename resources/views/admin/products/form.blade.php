@extends('layouts.admin')

@section('title', $product->exists ? 'Edit: '.$product->name : 'New Product')

@section('content')
    <form method="POST" enctype="multipart/form-data"
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
          class="grid gap-6 xl:grid-cols-3">
        @csrf
        @if($product->exists) @method('PUT') @endif

        {{-- Main column --}}
        <div class="xl:col-span-2 space-y-6">
            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Basics</h2>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-input-label for="name" value="Product Name *" />
                        <x-text-input id="name" name="name" class="mt-1.5 block w-full" :value="old('name', $product->name)" required />
                    </div>
                    <div>
                        <x-input-label for="slug" value="Slug (URL)" />
                        <x-text-input id="slug" name="slug" class="mt-1.5 block w-full" :value="old('slug', $product->slug)" placeholder="auto-generated from name" />
                    </div>
                </div>

                <div>
                    <x-input-label for="short_description" value="Short Description" />
                    <textarea id="short_description" name="short_description" rows="2" maxlength="500"
                              class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div>
                    <x-input-label for="long_description" value="Long Description" />
                    <textarea id="long_description" name="long_description" rows="7"
                              class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('long_description', $product->long_description) }}</textarea>
                    <p class="mt-1 text-xs text-slate-400">Separate paragraphs with a blank line.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-input-label for="features" value="Features (one per line)" />
                        <textarea id="features" name="features" rows="6"
                                  class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('features', implode("\n", $product->features ?? [])) }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="tech_stack" value="Tech Stack (one per line)" />
                        <textarea id="tech_stack" name="tech_stack" rows="6"
                                  class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('tech_stack', implode("\n", $product->tech_stack ?? [])) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Images</h2>

                <div class="grid gap-5 sm:grid-cols-3">
                    @foreach([
                        'logo_file' => ['label' => 'Product Logo', 'current' => $product->logo],
                        'cover_image_file' => ['label' => 'Cover Image', 'current' => $product->cover_image],
                        'hero_image_file' => ['label' => 'Hero Image', 'current' => $product->hero_image],
                    ] as $field => $meta)
                        <div>
                            <x-input-label :for="$field" :value="$meta['label']" />
                            @if($meta['current'])
                                <img src="{{ media_url($meta['current']) }}" alt="" class="mt-2 h-20 w-full rounded-xl object-cover bg-slate-100 dark:bg-slate-800">
                            @endif
                            <input type="file" id="{{ $field }}" name="{{ $field }}" accept="image/*"
                                   class="mt-2 block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary-700 dark:file:bg-primary-950 dark:file:text-primary-300 hover:file:bg-primary-100">
                        </div>
                    @endforeach
                </div>

                <div>
                    <x-input-label for="gallery_files" value="Gallery / Screenshots (multiple)" />
                    <input type="file" id="gallery_files" name="gallery_files[]" accept="image/*" multiple
                           class="mt-2 block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary-700 dark:file:bg-primary-950 dark:file:text-primary-300 hover:file:bg-primary-100">

                    @if($product->exists && $product->images->isNotEmpty())
                        <div class="mt-4 grid grid-cols-3 sm:grid-cols-5 gap-3">
                            @foreach($product->images as $image)
                                <div class="relative group">
                                    <img src="{{ media_url($image->path) }}" alt="" class="aspect-square w-full rounded-xl object-cover bg-slate-100 dark:bg-slate-800">
                                    <button type="submit"
                                            formaction="{{ route('admin.products.images.destroy', [$product, $image]) }}"
                                            formmethod="POST" name="_method" value="DELETE"
                                            onclick="return confirm('Remove this image?')"
                                            class="absolute top-1.5 right-1.5 hidden group-hover:flex h-6 w-6 items-center justify-center rounded-full bg-rose-600 text-white text-xs"
                                            aria-label="Remove image">✕</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Links & CTA</h2>
                <div class="grid gap-5 sm:grid-cols-3">
                    <div>
                        <x-input-label for="website_url" value="Website URL" />
                        <x-text-input id="website_url" name="website_url" type="url" class="mt-1.5 block w-full" :value="old('website_url', $product->website_url)" />
                    </div>
                    <div>
                        <x-input-label for="demo_url" value="Demo URL" />
                        <x-text-input id="demo_url" name="demo_url" type="url" class="mt-1.5 block w-full" :value="old('demo_url', $product->demo_url)" />
                    </div>
                    <div>
                        <x-input-label for="github_url" value="GitHub URL" />
                        <x-text-input id="github_url" name="github_url" type="url" class="mt-1.5 block w-full" :value="old('github_url', $product->github_url)" />
                    </div>
                    <div>
                        <x-input-label for="button_text" value="Button Text" />
                        <x-text-input id="button_text" name="button_text" class="mt-1.5 block w-full" :value="old('button_text', $product->button_text)" placeholder="Visit Product" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="button_url" value="Button URL" />
                        <x-text-input id="button_url" name="button_url" class="mt-1.5 block w-full" :value="old('button_url', $product->button_url)" />
                    </div>
                </div>
            </div>

            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">SEO</h2>
                <div class="grid gap-5">
                    <div>
                        <x-input-label for="seo_title" value="SEO Title" />
                        <x-text-input id="seo_title" name="seo_title" class="mt-1.5 block w-full" :value="old('seo_title', $product->seo_title)" />
                    </div>
                    <div>
                        <x-input-label for="seo_description" value="SEO Description" />
                        <textarea id="seo_description" name="seo_description" rows="2" maxlength="500"
                                  class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('seo_description', $product->seo_description) }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="seo_keywords" value="SEO Keywords (comma separated)" />
                        <x-text-input id="seo_keywords" name="seo_keywords" class="mt-1.5 block w-full" :value="old('seo_keywords', $product->seo_keywords)" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar column --}}
        <div class="space-y-6">
            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Publish</h2>

                <div>
                    <x-input-label for="status" value="Status *" />
                    <select id="status" name="status" class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                        @foreach(['draft' => 'Draft', 'published' => 'Published', 'hidden' => 'Hidden'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $product->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="published_at" value="Publish Date" />
                    <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1.5 block w-full"
                                  :value="old('published_at', $product->published_at?->format('Y-m-d\TH:i'))" />
                </div>

                <label class="flex items-center gap-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    <input type="checkbox" name="featured" value="1" @checked(old('featured', $product->featured))
                           class="rounded border-slate-300 dark:border-slate-700 text-primary-600 focus:ring-primary-500">
                    Featured product
                </label>

                <div>
                    <x-input-label for="display_order" value="Display Order" />
                    <x-text-input id="display_order" name="display_order" type="number" min="0" class="mt-1.5 block w-full"
                                  :value="old('display_order', $product->display_order ?? 0)" />
                </div>
            </div>

            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Organization</h2>

                <div>
                    <x-input-label for="category_id" value="Category" />
                    <select id="category_id" name="category_id" class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">— None —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="tags" value="Tags (comma separated)" />
                    <x-text-input id="tags" name="tags" class="mt-1.5 block w-full"
                                  :value="old('tags', $product->exists ? $product->tags->pluck('name')->implode(', ') : '')" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="version" value="Version" />
                        <x-text-input id="version" name="version" class="mt-1.5 block w-full" :value="old('version', $product->version)" />
                    </div>
                    <div>
                        <x-input-label for="platform" value="Platform" />
                        <x-text-input id="platform" name="platform" class="mt-1.5 block w-full" :value="old('platform', $product->platform)" placeholder="Web · PWA" />
                    </div>
                </div>
            </div>

            <div class="card-premium p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Appearance</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="color_theme" value="Color Theme" />
                        <input type="color" id="color_theme" name="color_theme" value="{{ old('color_theme', $product->color_theme ?? '#6366f1') }}"
                               class="mt-1.5 h-10 w-full rounded-xl border-slate-300 dark:border-slate-700 cursor-pointer">
                    </div>
                    <div>
                        <x-input-label for="icon" value="Icon name" />
                        <x-text-input id="icon" name="icon" class="mt-1.5 block w-full" :value="old('icon', $product->icon)" placeholder="building-office-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="background_style" value="Background Style" />
                    <select id="background_style" name="background_style" class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                        @foreach(['gradient', 'solid', 'grid', 'particles'] as $style)
                            <option value="{{ $style }}" @selected(old('background_style', $product->background_style) === $style)>{{ ucfirst($style) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="animation_style" value="Animation Style" />
                    <select id="animation_style" name="animation_style" class="mt-1.5 block w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                        @foreach(['fade', 'zoom', 'parallax', 'blur'] as $style)
                            <option value="{{ $style }}" @selected(old('animation_style', $product->animation_style) === $style)>{{ ucfirst($style) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1">{{ $product->exists ? 'Save Changes' : 'Create Product' }}</button>
                <a href="{{ route('admin.products.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
@endsection
