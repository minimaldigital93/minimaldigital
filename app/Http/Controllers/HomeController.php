<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\HomepageSection;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomepageSection::active()->ordered()->get();

        $slides = HeroSlide::active()->ordered()->with('product')->get();

        $products = Product::published()->ordered()
            ->with(['category', 'tags'])
            ->get();

        return view('home', compact('sections', 'slides', 'products'));
    }
}
