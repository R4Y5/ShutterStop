<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Show all orders
     */
    public function index()
    {
        // Admin sees all orders
        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.edit', compact('order'));
    }

    // Order details
    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }
    
    // Update status
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
