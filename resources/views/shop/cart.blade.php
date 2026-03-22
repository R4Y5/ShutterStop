@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Shopping Cart</h2>

    @if($cartItems->count())
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th style="width:200px;">Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>₱{{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                @method('PUT')
                                <!-- Decrement -->
                                <button type="button" class="btn btn-sm btn-outline-secondary me-2"
                                        onclick="changeQuantity({{ $id }}, -1)">–</button>

                                <!-- Quantity input -->
                                <input type="number" name="quantity"
                                       id="quantity-{{ $id }}"
                                       value="{{ $item['quantity'] }}"
                                       min="1"
                                       class="form-control text-center"
                                       style="width:70px;">

                                <!-- Increment -->
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2"
                                        onclick="changeQuantity({{ $id }}, 1)">+</button>

                                <!-- Update -->
                                <button type="submit" class="btn btn-sm btn-primary ms-3">Update</button>
                            </form>
                        </td>
                        <td>₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

          <div class="text-end">
            <h4>Total: ₱{{ number_format($cartTotal, 2) }}</h4>

            <form action="{{ route('cart.clear') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-warning">Clear Cart</button>
    </form>
            <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @else
        <p class="text-muted">Your cart is empty.</p>
    @endif
</div>

{{-- JS for increment/decrement --}}
<script>
function changeQuantity(itemId, change) {
    const input = document.getElementById('quantity-' + itemId);
    let current = parseInt(input.value);
    let min = parseInt(input.min);

    let newValue = current + change;
    if (newValue < min) newValue = min;

    input.value = newValue;
}
</script>
@endsection
