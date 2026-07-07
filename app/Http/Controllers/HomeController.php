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

        // Hide slides whose attached product is no longer publicly visible,
        // so the hero never links to a 404. Product-less slides are unaffected.
        $slides = HeroSlide::active()->ordered()
            ->where(function ($query) {
                $query->whereNull('product_id')
                    ->orWhereHas('product', fn ($product) => $product->published());
            })
            ->with('product')
            ->get();

        $products = Product::published()->ordered()
            ->with(['category', 'tags'])
            ->get();

        return view('home', compact('sections', 'slides', 'products'));
    }
}
