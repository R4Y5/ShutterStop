@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="hero-text">
        <h2>Shopping Cart.</h2>
    </div>

    <style>
        /* Page Title */
        .hero-text h2 {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        /* Table Container */
        .cart-wrapper {
            background: #fff;
            border: 3px solid #000;
            box-shadow: 10px 10px 0px 0px #000;
            padding: 20px;
            margin-bottom: 40px;
        }

        .table-retro {
            border-collapse: collapse !important;
        }

        .table-retro thead th {
            background-color: #000 !important;
            color: #fff !important;
            text-transform: uppercase;
            font-weight: 900;
            border: 1px solid #000;
            padding: 15px;
        }

        .table-retro tbody td {
            border: 1px solid #000 !important;
            font-weight: bold;
            padding: 15px;
        }

        /* Inputs */
        .form-control-retro {
            border: 2px solid #000 !important;
            border-radius: 0 !important;
            font-weight: bold;
        }

        .form-control-retro:focus {
            box-shadow: 4px 4px 0px 0px #000;
            outline: none;
        }

        /* Custom Checkbox */
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #ff0000;
            cursor: pointer;
            border: 2px solid #000;
        }

        /* Total Banner */
        .total-banner {
            background-color: #ffff00; /* Neon Yellow */
            border: 3px solid #000;
            padding: 20px;
            font-weight: 900;
            text-transform: uppercase;
            box-shadow: 6px 6px 0px 0px #000;
            margin-bottom: 25px;
        }

        /* Buttons */
        .btn-retro {
            border: 2px solid #000;
            border-radius: 0;
            font-weight: 900;
            text-transform: uppercase;
            padding: 12px 25px;
            transition: all 0.2s;
            box-shadow: 4px 4px 0px 0px #000;
            display: inline-block;
            text-decoration: none;
            color: #000;
        }

        .btn-retro:hover {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #000;
            color: #000;
        }

        .btn-update { background-color: #ffa500; }
        .btn-add { background-color: #fff; }
        .btn-place { background-color: #00ff00; width: 100%; text-align: center; }

        .empty-state {
            border: 4px dashed #000;
            padding: 50px;
            text-align: center;
            background: #fff;
            font-weight: 900;
            text-transform: uppercase;
        }
    </style>

    @if($cartItems->count())
        <div class="cart-wrapper">
            <form action="{{ route('cart.updateAll') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="table-responsive">
                    <table class="table table-retro align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Remove</th>
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
                                    <td class="text-center">
                                        <input type="checkbox" name="remove[]" value="{{ $id }}">
                                    </td>
                                    <td>
                                        <input type="number" name="quantities[{{ $id }}]"
                                               value="{{ $item['quantity'] }}" min="1"
                                               class="form-control-retro text-center" style="width:80px;">
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['brand'] ?? '—' }}</td>
                                    <td>₱{{ number_format($item['price'], 2) }}</td>
                                    <td>₱{{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="total-banner mt-4 text-end">
                    <h4 class="mb-0">Total Amount Payable: ₱{{ number_format($total, 2) }}</h4>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/shop') }}" class="btn-retro btn-add">Add More Items</a>
                    <button type="submit" class="btn-retro btn-update">Update Cart</button>
                </div>
            </form>

            <hr class="my-5" style="border-top: 3px solid #000; opacity: 1;">

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="remarks" class="fw-black text-uppercase small mb-2 d-block">Order Remarks</label>
                    <textarea name="remarks" id="remarks" rows="3"
                              class="form-control-retro w-100 p-3"
                              placeholder="Any special instructions for your order?">{{ old('remarks', session('cart_remarks')) }}</textarea>
                </div>

                <button type="submit" class="btn-retro btn-place">
                    Place Order Now
                </button>
            </form>
        </div>
    @else
        <div class="empty-state">
            <h4 class="mb-4">Your cart is empty.</h4>
            <a href="{{ url('/shop') }}" class="btn-retro btn-add">Go to Shop</a>
        </div>
    @endif
</div>
@endsection
