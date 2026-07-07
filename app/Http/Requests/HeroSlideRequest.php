<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HeroSlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function rules(): array
    {
        return [
            'product_id' => ['nullable', 'exists:products,id'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg,gif', 'max:8192'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg,gif', 'max:4096'],
            'badges' => ['nullable', 'string', 'max:500'],
            'animation' => ['required', Rule::in(['fade', 'zoom', 'parallax', 'blur'])],
            'cta_primary_text' => ['nullable', 'string', 'max:100'],
            'cta_primary_url' => ['nullable', 'string', 'max:255'],
            'cta_secondary_text' => ['nullable', 'string', 'max:100'],
            'cta_secondary_url' => ['nullable', 'string', 'max:255'],
            'color_theme' => ['nullable', 'string', 'max:30'],
            'is_active' => ['boolean'],
            'display_order' => ['nullable', 'integer', 'min:0', 'max:65000'],
        ];
    }
}
