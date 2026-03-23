@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Checkout</h2>

    @if(empty($cart))
        <p class="text-muted">Your cart is empty.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>₱{{ number_format($item['price'], 2) }}</td>
                        <td>₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Total:</strong> ₱{{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2) }}</p>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Place Order</button>
        </form>
    @endif
</div>
@endsection
