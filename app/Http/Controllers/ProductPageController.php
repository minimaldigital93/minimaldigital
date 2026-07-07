<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductPageController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::published()
            ->where('slug', $slug)
            ->with(['category', 'tags', 'images'])
            ->firstOrFail();

        $related = Product::published()->ordered()
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
