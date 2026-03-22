<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Show cart contents.
     */
    public function index()
{
    $cart = session()->get('cart', []);

    // Convert session cart array into a collection for easier handling
    $cartItems = collect($cart);

    $cartTotal = $cartItems->sum(function($item) {
        return $item['price'] * $item['quantity'];
    });

    return view('shop.cart', compact('cartItems', 'cartTotal'));
}

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
{
    $cart = session()->get('cart', []);

    // Get quantity from request, default to 1
    $quantity = (int) $request->input('quantity', 1);

    if (isset($cart[$product->id])) {
        // Add the requested quantity to existing
        $cart[$product->id]['quantity'] += $quantity;
    } else {
        $cart[$product->id] = [
            'name'     => $product->name,
            'quantity' => $quantity,
            'price'    => $product->price,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Product added to cart!');
}

    /**
     * Update product quantity in the cart.
     */
    public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $quantity = (int) $request->input('quantity', 1);

        // Prevent exceeding stock
        $product = Product::findOrFail($id);
        if ($quantity > $product->stock) {
            $quantity = $product->stock;
        }

        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);
    }

    return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
}

    /**
     * Remove a product from the cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed!');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
