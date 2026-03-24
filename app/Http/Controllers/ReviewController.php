<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;

class ReviewController extends Controller
{
    /**
     * Show the "Write Review" form for a product.
     */
    public function form(Product $product, Request $request)
    {
        // Ensure the user has a completed order for this product
        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->first();

        if (!$order) {
            return redirect()->route('account.orders')
                ->with('error', 'You can only review products from completed orders.');
        }

        // Fetch existing review if any
        $review = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('order_id', $order->id)
            ->first();

        return view('products.reviews.create', compact('product', 'order', 'review'));
    }

    /**
     * Store a new review.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_id'=> 'required|integer',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->first();

        if (!$order) {
            return back()->with('error', 'You can only review products from completed orders.');
        }

        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id, 'order_id' => $order->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return redirect()->route('account.orders')
            ->with('success', 'Review submitted successfully!');
    }

    /**
     * Show the "Edit Review" form.
     */
    public function edit(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (strtolower($review->order->status) !== 'completed') {
            return redirect()->route('account.orders')
                ->with('error', 'You can only edit reviews from completed orders.');
        }

        return view('products.reviews.edit', compact('review'));
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (strtolower($review->order->status) !== 'completed') {
            return back()->with('error', 'You can only update reviews from completed orders.');
        }

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('account.orders')
            ->with('success', 'Review updated successfully!');
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
            ->addColumn('actions', function($review) {
                return '<button class="btn btn-danger btn-sm delete-review" data-id="'.$review->id.'">Delete</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['success' => true]);
    }
}
