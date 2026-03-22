<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
     * Show checkout page (optional).
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('shop.checkout', compact('cart', 'total'));
    }

    /**
     * Process checkout: create order + order items.
     */
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total'   => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status'  => 'pending', // you can update later to 'paid' or 'shipped'
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('account.orders')->with('success', 'Order placed successfully!');
    }
}
