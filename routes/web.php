<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\HomepageSectionController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{slug}', [ProductPageController::class, 'show'])->name('products.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Breeze's default dashboard redirects into the admin area.
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin CMS  (/admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])
        ->name('products.images.destroy');

    Route::post('slides/reorder', [HeroSlideController::class, 'reorder'])->name('slides.reorder');
    Route::post('slides/settings', [HeroSlideController::class, 'updateSettings'])->name('slides.settings');
    Route::post('slides/{slide}/toggle', [HeroSlideController::class, 'toggle'])->name('slides.toggle');
    Route::resource('slides', HeroSlideController::class)->except(['show']);

    Route::resource('media', MediaController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('homepage', [HomepageSectionController::class, 'index'])->name('homepage.index');
    Route::post('homepage/reorder', [HomepageSectionController::class, 'reorder'])->name('homepage.reorder');
    Route::post('homepage/{section}/toggle', [HomepageSectionController::class, 'toggle'])->name('homepage.toggle');

    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
