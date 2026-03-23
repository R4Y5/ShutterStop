<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderReceiptMail;
use App\Mail\OrderStatusUpdatedMail;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $remarks = session('cart_remarks'); // get remarks saved from cart
        return view('checkout.index', compact('cart'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Your cart is empty.');
        }

        $remarks = $request->input('remarks', session('cart_remarks'));

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'status'  => 'Pending',
            'total'   => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'remarks'    => $remarks,
        ]);

        // Save order items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            // Optionally reduce stock
            Product::where('id', $productId)->decrement('stock', $item['quantity']);
        }

        // Clear cart
        session()->forget('cart');
        session()->forget('cart_remarks');

        // Send receipt email (HTML view)
        Mail::to($user->email)->send(new OrderReceiptMail($order));

        return redirect()->route('account.orders')
                         ->with('success', 'Transaction completed! Receipt sent to your email.');
    }

    /**
     * Admin updates order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        // Send email with PDF receipt attached
        Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));

        return back()->with('success', 'Order status updated and email sent.');
    }
}
