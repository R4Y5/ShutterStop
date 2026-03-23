<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    /**
     * Show all products in the shop.
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category'); // eager load category

        // Optionally filter products by search/category
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        // Fetch all products (no status filter since your table doesn’t have that column)
        $products = Product::paginate(12);

        return view('shop.index', compact('products', 'categories'));
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
