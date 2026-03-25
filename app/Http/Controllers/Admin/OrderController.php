<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceiptMail;

class OrderController extends Controller
{
    /**
     * Show all orders
     */
    public function index()
    {
        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        $customers = User::all();       // dropdown for customer names
        $products  = Product::all();    // dropdown for items
        $statuses  = ['Pending','Processing','Shipped','Completed','Cancelled']; // dropdown for status

        return view('admin.orders.create', compact('customers','products','statuses'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'status'     => 'required|in:Pending,Processing,Shipped,Completed,Cancelled',
            'address'    => 'nullable|string|max:255',
            'remarks'    => 'nullable|string',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product   = Product::findOrFail($request->product_id);
        $lineTotal = $product->price * $request->quantity;

        // Create order
        $order = Order::create([
            'user_id' => $request->user_id,
            'status'  => $request->status,
            'address' => $request->address,
            'remarks' => $request->remarks,
            'total'   => $lineTotal,
        ]);

        // Create order item
        $order->items()->create([
            'product_id' => $product->id,
            'price'      => $product->price,
            'quantity'   => $request->quantity,
        ]);

        Mail::to($order->user->email)->send(new OrderReceiptMail($order));

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order created successfully.');
    }

    /**
     * Edit an existing order
     */
    public function edit(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Completed,Cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }

    /**
     * Delete an order
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }
    
    /**
     * Update order details
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'status'  => 'required|in:Pending,Processing,Shipped,Completed,Cancelled',
        ]);

        $order->update($request->only('address', 'remarks', 'status'));

        return redirect()->route('admin.orders.index')
                        ->with('success', 'Order updated successfully.');
    }
}
