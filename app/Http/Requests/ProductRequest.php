<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name', '')),
            'featured' => $this->boolean('featured'),
        ]);
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
            'short_description' => ['nullable', 'string', 'max:500'],
            'long_description' => ['nullable', 'string', 'max:50000'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg,gif', 'max:4096'],
            'cover_image_file' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg,gif', 'max:8192'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg,gif', 'max:8192'],
            'gallery_files' => ['nullable', 'array', 'max:12'],
            'gallery_files.*' => ['image', 'mimes:jpeg,png,webp,svg,gif', 'max:8192'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['nullable', 'string', 'max:500'],
            'version' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in(['draft', 'published', 'hidden'])],
            'featured' => ['boolean'],
            'platform' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'string', 'max:5000'],
            'tech_stack' => ['nullable', 'string', 'max:2000'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0', 'max:65000'],
            'published_at' => ['nullable', 'date'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_keywords' => ['nullable', 'string', 'max:500'],
            'color_theme' => ['nullable', 'string', 'max:30'],
            'background_style' => ['nullable', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:100'],
            'animation_style' => ['nullable', 'string', 'max:50'],
        ];
    }
}
