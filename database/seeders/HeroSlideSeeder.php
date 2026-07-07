<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use App\Models\Product;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $ams = Product::where('slug', 'ams')->first();
        $smart = Product::where('slug', 'smart')->first();

        HeroSlide::updateOrCreate(['title' => 'AMS', 'display_order' => 1], [
            'product_id' => $ams?->id,
            'subtitle' => 'Apartment Management System',
            'description' => 'Manage properties, rooms, tenants, billing, payments, reports and analytics — all from one beautiful dashboard.',
            'image' => '/images/products/ams-hero.svg',
            'logo' => '/images/products/ams-logo.svg',
            'badges' => ['Properties', 'Tenants', 'Billing', 'Payments', 'Analytics'],
            'animation' => 'parallax',
            'cta_primary_text' => 'Learn More',
            'cta_primary_url' => '/products/ams',
            'cta_secondary_text' => 'Visit Product',
            'cta_secondary_url' => 'https://ams.minidigital.dev',
            'color_theme' => '#6366f1',
            'is_active' => true,
        ]);

        HeroSlide::updateOrCreate(['title' => 'SmartSell', 'display_order' => 2], [
            'product_id' => $smart?->id,
            'subtitle' => 'POS & Inventory System',
            'description' => 'Sell faster with barcode POS, live inventory, KHQR payments and real-time sales analytics.',
            'image' => '/images/products/smart-hero.svg',
            'logo' => '/images/products/smart-logo.svg',
            'badges' => ['Inventory', 'POS', 'Barcode', 'KHQR Payment', 'Analytics'],
            'animation' => 'zoom',
            'cta_primary_text' => 'Learn More',
            'cta_primary_url' => '/products/smart',
            'cta_secondary_text' => 'Visit Product',
            'cta_secondary_url' => 'https://smart.minidigital.dev',
            'color_theme' => '#10b981',
            'is_active' => true,
        ]);
    }
}
