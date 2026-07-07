<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $propertyCat = Category::where('slug', 'property-management')->first();
        $posCat = Category::where('slug', 'point-of-sale')->first();

        $ams = Product::updateOrCreate(['slug' => 'ams'], [
            'name' => 'AMS',
            'short_description' => 'Apartment Management System — manage properties, rooms, tenants, billing, payments, reports and analytics in one place.',
            'long_description' => "AMS is a complete Apartment Management System built for landlords and property managers who want to run their buildings without spreadsheets.\n\nFrom onboarding tenants to generating monthly invoices, tracking utility usage, collecting payments and understanding occupancy trends — AMS handles the entire lifecycle of property management with a clean, fast interface.",
            'logo' => '/images/products/ams-logo.svg',
            'cover_image' => '/images/products/ams-cover.svg',
            'hero_image' => '/images/products/ams-hero.svg',
            'website_url' => 'https://ams.minimaldigital.dev',
            'demo_url' => 'https://ams.minimaldigital.dev',
            'category_id' => $propertyCat?->id,
            'version' => '2.0',
            'status' => 'published',
            'featured' => true,
            'platform' => 'Web · PWA',
            'features' => [
                'Property & room management',
                'Tenant profiles & contracts',
                'Automated monthly billing',
                'Utility meter tracking',
                'Payment collection & receipts',
                'Reports & occupancy analytics',
            ],
            'tech_stack' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
            'stats' => [
                ['value' => '500+', 'label' => 'Rooms managed'],
                ['value' => '99.9%', 'label' => 'Uptime'],
                ['value' => '10x', 'label' => 'Faster billing'],
                ['value' => '24/7', 'label' => 'Access anywhere'],
            ],
            'faqs' => [
                ['question' => 'Can AMS handle multiple buildings?', 'answer' => 'Yes — AMS supports unlimited properties, each with its own rooms, tenants and billing cycles.'],
                ['question' => 'Does AMS support utility billing?', 'answer' => 'Water and electricity meters can be recorded monthly, and charges are added to invoices automatically.'],
                ['question' => 'Can tenants see their invoices?', 'answer' => 'Tenants receive clear, itemized invoices and payment receipts every cycle.'],
            ],
            'button_text' => 'Visit Product',
            'button_url' => 'https://ams.minimaldigital.dev',
            'display_order' => 1,
            'published_at' => now(),
            'seo_title' => 'AMS — Apartment Management System',
            'seo_description' => 'Manage properties, rooms, tenants, billing, payments, reports and analytics with AMS by MinimalDigital.',
            'seo_keywords' => 'apartment management, property management, tenant billing, AMS',
            'color_theme' => '#6366f1',
            'background_style' => 'gradient',
            'icon' => 'building-office-2',
            'animation_style' => 'parallax',
        ]);

        $smart = Product::updateOrCreate(['slug' => 'smart'], [
            'name' => 'SmartSell',
            'short_description' => 'SmartSell POS & Inventory — barcode sales, stock control, KHQR payments and real-time analytics for modern retail.',
            'long_description' => "SmartSell is a modern Point of Sale and Inventory system designed for shops that want to sell faster and know their numbers.\n\nScan barcodes, accept KHQR payments, track every unit of stock and watch sales analytics update in real time. SmartSell works beautifully on desktops, tablets and phones — online or as an installable PWA.",
            'logo' => '/images/products/smart-logo.svg',
            'cover_image' => '/images/products/smart-cover.svg',
            'hero_image' => '/images/products/smart-hero.svg',
            'website_url' => 'https://smartsell.minimaldigital.dev',
            'demo_url' => 'https://smartsell.minimaldigital.dev',
            'category_id' => $posCat?->id,
            'version' => '1.5',
            'status' => 'published',
            'featured' => true,
            'platform' => 'Web · PWA',
            'features' => [
                'Fast barcode point of sale',
                'Inventory & stock control',
                'KHQR payment integration',
                'Sales & profit analytics',
                'Multi-user with roles',
                'Receipt printing',
            ],
            'tech_stack' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
            'stats' => [
                ['value' => '2s', 'label' => 'Average checkout'],
                ['value' => '100%', 'label' => 'Stock accuracy'],
                ['value' => 'KHQR', 'label' => 'Instant payments'],
                ['value' => 'Live', 'label' => 'Sales analytics'],
            ],
            'faqs' => [
                ['question' => 'Does SmartSell work offline?', 'answer' => 'SmartSell is an installable PWA; core screens stay usable during short connection drops and sync when you are back online.'],
                ['question' => 'Which payments are supported?', 'answer' => 'Cash and KHQR (Bakong) payments out of the box, with itemized receipts for both.'],
                ['question' => 'Can I track stock across suppliers?', 'answer' => 'Yes — purchases, adjustments and low-stock alerts keep inventory accurate to the unit.'],
            ],
            'button_text' => 'Visit Product',
            'button_url' => 'https://smartsell.minimaldigital.dev',
            'display_order' => 2,
            'published_at' => now(),
            'seo_title' => 'SmartSell — POS & Inventory System',
            'seo_description' => 'Barcode POS, inventory control, KHQR payments and real-time analytics with SmartSell by MinimalDigital.',
            'seo_keywords' => 'POS, inventory, barcode, KHQR, point of sale, SmartSell',
            'color_theme' => '#10b981',
            'background_style' => 'gradient',
            'icon' => 'shopping-cart',
            'animation_style' => 'zoom',
        ]);

        $tagMap = [
            'ams' => ['Property', 'Billing', 'Analytics', 'SaaS'],
            'smart' => ['Inventory', 'POS', 'Barcode', 'KHQR', 'Analytics'],
        ];

        foreach ([$ams, $smart] as $product) {
            $ids = collect($tagMap[$product->slug])->map(function (string $name) {
                return Tag::updateOrCreate(['slug' => str($name)->slug()->toString()], ['name' => $name])->id;
            });
            $product->tags()->sync($ids);
        }
    }
}
