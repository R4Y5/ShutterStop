<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;

class ReviewController extends Controller
{
    /**
     * Show the review form for a product.
     */
    public function form(Product $product)
    {
        // Check if the logged-in user has a completed order for this product
        $hasCompletedOrder = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasCompletedOrder) {
            return redirect()->route('account.orders')
                ->with('error', 'You can only review products you have purchased and completed.');
        }

        // Fetch existing review if it exists
        $review = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        return view('products.review', compact('product', 'review'));
    }

    /**
     * Store or update the review.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Ensure user has completed order for this product
        $hasCompletedOrder = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->exists();

        if (!$hasCompletedOrder) {
            return back()->with('error', 'You can only review products you purchased and completed.');
        }

        // Create or update review
        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Review saved successfully!');
    }

    /**
     * Show all reviews of the logged-in customer.
     */
    public function myReviews()
    {
        $reviews = Review::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('account.reviews', compact('reviews'));
    }

    /**
     * Admin DataTable listing of all reviews.
     */
    public function getData()
    {
        $query = Review::with(['product','user'])->select('reviews.*');

        return \Yajra\DataTables\Facades\DataTables::of($query)
            ->addColumn('product', fn($review) => $review->product->name)
            ->addColumn('user', fn($review) => $review->user->first_name . ' ' . $review->user->last_name)
            ->editColumn('created_at', fn($review) => $review->created_at->format('Y-m-d'))
            ->make(true);
    }
}
