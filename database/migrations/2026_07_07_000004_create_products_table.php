<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description', 500)->nullable();
            $table->longText('long_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('website_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('github_url')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('version', 50)->nullable();
            $table->enum('status', ['draft', 'published', 'hidden'])->default('draft')->index();
            $table->boolean('featured')->default(false)->index();
            $table->string('platform')->nullable();
            $table->json('features')->nullable();
            $table->json('tech_stack')->nullable();
            $table->json('stats')->nullable();
            $table->json('faqs')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->unsignedInteger('display_order')->default(0)->index();
            $table->timestamp('published_at')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();
            $table->string('seo_keywords', 500)->nullable();
            $table->string('color_theme', 30)->nullable();
            $table->string('background_style', 50)->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('animation_style', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
