@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Order #{{ $order->id }}</h2>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Customer Name (Uneditable) -->
        <div class="mb-3">
            <label class="form-label">Customer</label>
            <input type="text" class="form-control" 
                   value="{{ $order->user->first_name }} {{ $order->user->last_name }}" disabled>
        </div>

        <!-- Order Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Order Status</label>
            <select name="status" id="status" class="form-select">
                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <!-- Shipping Address -->
        <div class="mb-3">
            <label for="address" class="form-label">Shipping Address</label>
            <input type="text" name="address" id="address" 
                   class="form-control" value="{{ old('address', $order->user->address) }}">
        </div>

        <!-- Remarks -->
        <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea name="remarks" id="remarks" rows="3" 
                      class="form-control">{{ old('remarks', $order->remarks) }}</textarea>
        </div>

        <!-- Order Items -->
        <h4 class="mt-4">Order Items</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->brand }}</td>
                        <td>₱{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>

    <!-- Delete Order -->
    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this order?')">
            Delete Order
        </button>
    </form>
</div>
@endsection
