<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::published()->ordered()->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('products'))
            ->header('Content-Type', 'application/xml');
    }
}
