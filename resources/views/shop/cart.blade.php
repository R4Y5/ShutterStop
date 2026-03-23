@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Shopping Cart</h2>

    @if($cartItems->count())
        <form action="{{ route('cart.updateAll') }}" method="POST">
            @csrf
            @method('PUT')

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Remove</th>
                        <th>Quantity</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cartItems as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="remove[]" value="{{ $id }}">
                            </td>
                            <td>
                                <input type="number" name="quantities[{{ $id }}]" 
                                       value="{{ $item['quantity'] }}" min="1" 
                                       class="form-control text-center" style="width:80px;">
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['brand'] ?? '' }}</td>
                            <td>₱{{ number_format($item['price'], 2) }}</td>
                            <td>₱{{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Amount Payable -->
            <div class="mb-3 text-end">
                <h4>Total Amount Payable: ₱{{ number_format($total, 2) }}</h4>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Update Cart</button>
                <a href="{{ url('/shop') }}" class="btn btn-secondary">Add Items</a>
            </div>
        </form>

        <!-- Checkout directly from cart -->
        <form action="{{ route('checkout.process') }}" method="POST" class="mt-3">
            @csrf

            <!-- ✅ Remarks moved here -->
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ old('remarks', session('cart_remarks')) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Place Order</button>
        </form>
    @else
        <p class="text-muted">Your cart is empty.</p>
        <a href="{{ url('/shop') }}" class="btn btn-primary">Go to Shop</a>
    @endif
</div>
@endsection
