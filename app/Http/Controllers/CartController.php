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

        // Backfill brand if missing (for older cart entries)
        foreach ($cart as $id => &$item) {
            if (!isset($item['brand'])) {
                $product = Product::find($id);
                $item['brand'] = $product ? $product->brand : '';
            }
        }
        session()->put('cart', $cart);

        $cartItems = collect($cart);

        $cartTotal = $cartItems->sum(function ($item) {
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

        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name'     => $product->name,
                'brand'    => $product->brand,   // ✅ brand stored
                'quantity' => $quantity,
                'price'    => $product->price,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Update multiple items in the cart at once.
     */
    public function updateAll(Request $request)
    {
        $cart = session()->get('cart', []);

        // Update quantities
        if ($request->has('quantities')) {
            foreach ($request->quantities as $id => $qty) {
                if (isset($cart[$id])) {
                    $product = Product::find($id);
                    if ($product) {
                        if ($qty > $product->stock) {
                            $qty = $product->stock;
                        }
                        // Ensure brand is always present
                        $cart[$id]['brand'] = $product->brand;
                    }
                    $cart[$id]['quantity'] = (int) $qty;
                }
            }
        }

        // Remove selected items
        if ($request->has('remove')) {
            foreach ($request->remove as $id) {
                unset($cart[$id]);
            }
        }

        // Save remarks in session (to carry over to checkout)
        if ($request->has('remarks')) {
            session(['cart_remarks' => $request->remarks]);
        }

        session()->put('cart', $cart);

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
        session()->forget('cart_remarks'); // also clear remarks
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
