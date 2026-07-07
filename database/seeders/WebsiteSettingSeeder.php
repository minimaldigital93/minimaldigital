<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            'company_name' => ['MinimalDigital', 'general'],
            'tagline' => ['Minimal Digital. Maximum Impact.', 'general'],
            'logo' => ['/images/brand/logo.svg', 'general'],
            'favicon' => ['/images/brand/favicon.svg', 'general'],
            'mission' => ['We build minimal, powerful software that helps businesses run beautifully — without the complexity.', 'general'],
            'vision' => ['A world where every small business has access to world-class digital tools.', 'general'],

            // Contact
            'address' => ['Phnom Penh, Cambodia', 'contact'],
            'phone' => ['+855 17 552 223', 'contact'],
            'email' => ['contact@minidigital.dev', 'contact'],

            // Social
            'facebook' => ['https://facebook.com/minidigital', 'social'],
            'telegram' => ['https://t.me/minidigital', 'social'],
            'github' => ['https://github.com/minidigital', 'social'],
            'linkedin' => ['', 'social'],
            'youtube' => ['', 'social'],
            'instagram' => ['', 'social'],

            // Footer
            'footer_text' => ['Crafted with care in Phnom Penh. Building minimal software with maximum impact.', 'footer'],
            'copyright' => ['© '.date('Y').' MinimalDigital. All rights reserved.', 'footer'],

            // SEO
            'seo_title' => ['MinimalDigital — Minimal Digital. Maximum Impact.', 'seo'],
            'seo_description' => ['MinimalDigital builds premium business software: AMS apartment management and SmartSell POS & inventory.', 'seo'],
            'seo_keywords' => ['minidigital, AMS, SmartSell, POS, apartment management, Cambodia software', 'seo'],
            'analytics_code' => ['', 'seo'],

            // Theme
            'primary_color' => ['#6366f1', 'theme'],
            'secondary_color' => ['#8b5cf6', 'theme'],
            'accent_color' => ['#10b981', 'theme'],
            'font_family' => ['Inter', 'theme'],
            'animations_enabled' => ['1', 'theme'],
            'default_theme' => ['auto', 'theme'],

            // Slideshow
            'slideshow_autoplay' => ['1', 'slideshow'],
            'slideshow_autoplay_delay' => ['6000', 'slideshow'],
            'slideshow_transition_duration' => ['900', 'slideshow'],
        ];

        foreach ($settings as $key => [$value, $group]) {
            WebsiteSetting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }
    }
}
