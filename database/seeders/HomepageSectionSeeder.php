<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['key' => 'hero', 'title' => 'Hero Slideshow', 'display_order' => 1],
            ['key' => 'products', 'title' => 'Products', 'display_order' => 2],
            ['key' => 'features', 'title' => 'Why MinimalDigital', 'display_order' => 3],
            ['key' => 'mission', 'title' => 'Mission & Vision', 'display_order' => 4],
            ['key' => 'stats', 'title' => 'Statistics', 'display_order' => 5],
            ['key' => 'faq', 'title' => 'FAQ', 'display_order' => 6],
            ['key' => 'contact', 'title' => 'Contact', 'display_order' => 7],
        ];

        foreach ($sections as $section) {
            HomepageSection::updateOrCreate(
                ['key' => $section['key']],
                $section + ['is_active' => true]
            );
        }
    }
}
