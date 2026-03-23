<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends Controller
{
    /**
     * Show all products in the shop.
     */
    public function index(Request $request)
{
    $query = Product::query();

    // apply filters (search, min_price, max_price, category, brand, type)
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    if ($request->filled('brand')) {
        $query->where('brand_id', $request->brand);
    }
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    $products = $query->paginate(12);
    $categories = Category::all();
    $brands = Brand::all();

    if ($request->ajax()) {
        return view('shop.partials.products', compact('products'))->render();
    }

    return view('shop.index', compact('products', 'categories', 'brands'));
}


    /**
     * Show a single product detail page.
     */
    public function show(Product $product)
    {
        $product->load(['reviews.user']);
        return view('shop.show', compact('product'));
    }

    /**
     * Submit a product review.
     */
    public function review(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted!');
    }
}
