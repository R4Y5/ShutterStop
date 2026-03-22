<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    /**
     * Show all products in the shop.
     */
    public function index()
    {
        // Fetch all products (no status filter since your table doesn’t have that column)
        $products = Product::paginate(12);

        return view('shop.index', compact('products'));
    }

    /**
     * Show a single product detail page.
     */
    public function show(Product $product)
    {
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
