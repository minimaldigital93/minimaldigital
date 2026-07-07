<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'short_description', 'long_description',
        'logo', 'cover_image', 'hero_image',
        'website_url', 'demo_url', 'github_url',
        'category_id', 'version', 'status', 'featured', 'platform',
        'features', 'tech_stack', 'stats', 'faqs',
        'button_text', 'button_url', 'display_order', 'published_at',
        'seo_title', 'seo_description', 'seo_keywords',
        'color_theme', 'background_style', 'icon', 'animation_style',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'features' => 'array',
            'tech_stack' => 'array',
            'stats' => 'array',
            'faqs' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('display_order');
    }

    public function slides(): HasMany
    {
        return $this->hasMany(HeroSlide::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(fn (Builder $q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
