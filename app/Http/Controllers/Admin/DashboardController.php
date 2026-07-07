<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Media;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'published_products' => Product::where('status', 'published')->count(),
            'hidden_products' => Product::whereIn('status', ['hidden', 'draft'])->count(),
            'slides' => HeroSlide::count(),
            'active_slides' => HeroSlide::where('is_active', true)->count(),
            'media' => Media::count(),
        ];

        $latestProducts = Product::latest()->take(5)->get();
        $recentUploads = Media::latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'latestProducts', 'recentUploads'));
    }
}
