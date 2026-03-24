@extends('layouts.app')

@section('content')
<style>
    /* Hero Title */
    .hero-text h2 {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        text-transform: uppercase;
        margin-bottom: 30px;
        text-align: center;
    }

    /* Message Styling */
    .alert-retro-success {
        background-color: #000;
        color: #fff;
        border-radius: 0;
        border: none;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 25px;
        box-shadow: 6px 6px 0px 0px #ccc;
    }

    /* Table Container Styling */
    .table-wrapper {
        background-color: #fff;
        border: 3px solid #000;
        box-shadow: 10px 10px 0px 0px #000;
        padding: 20px;
        margin-bottom: 40px;
    }

    .table-retro {
        border-collapse: collapse !important;
        margin-bottom: 0;
    }

    .table-retro thead th {
        background-color: #000 !important;
        color: #fff !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 900;
        border: 1px solid #000;
        padding: 15px;
    }

    .table-retro tbody td {
        border: 1px solid #000 !important;
        font-weight: bold;
        vertical-align: middle;
        padding: 15px;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border: 2px solid #000;
        background: #fff;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    /* Order Item List */
    .order-item-container {
        padding: 10px;
        background: #f9f9f9;
        border: 1px dashed #000;
        margin-bottom: 10px;
    }

    /* Action Buttons - Matched to btn-retro */
    .btn-retro-sm {
        border: 2px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.7rem;
        padding: 8px 12px;
        transition: all 0.2s;
        box-shadow: 4px 4px 0px 0px #000;
        text-decoration: none;
        display: inline-block;
    }

    .btn-retro-sm:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #fff;
    }

    .btn-write { background-color: #00ff00; color: #000; }
    .btn-update { background-color: #ffff00; color: #000; }
    .btn-write:hover, .btn-update:hover { background-color: #000; }

    .empty-state {
        border: 4px dashed #000;
        padding: 50px;
        text-align: center;
        background: #fff;
        font-weight: 900;
        text-transform: uppercase;
    }
</style>

<div class="container py-5">
    <div class="hero-text">
        <h2>My Orders.</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-retro-success text-center">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-state">
            <h4>No orders found.</h4>
        </div>
    @else
        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table table-retro">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Items & Reviews</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="text-center">#{{ $order->id }}</td>
                                <td>
                                    <span class="status-badge">{{ $order->status }}</span>
                                </td>
                                <td>₱{{ number_format($order->total, 2) }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    @foreach($order->items as $item)
                                        <div class="order-item-container">
                                            <div class="mb-2">
                                                <strong>{{ $item->product->name }}</strong>
                                                <span class="text-muted">(x{{ $item->quantity }})</span>
                                            </div>

                                            @php
                                                $review = $item->product->reviews()
                                                    ->where('user_id', auth()->id())
                                                    ->where('order_id', $order->id)
                                                    ->first();
                                            @endphp

                                            @if(strtolower($order->status) === 'completed')
                                                @if($review)
                                                    <a href="{{ route('account.reviews.edit', $review->id) }}"
                                                       class="btn-retro-sm btn-update">
                                                        Update Review
                                                    </a>
                                                @else
                                                    <a href="{{ route('products.review.form', $item->product->id) }}?order_id={{ $order->id }}"
                                                       class="btn-retro-sm btn-write">
                                                        Write Review
                                                    </a>
                                                @endif
                                            @else
                                                <small class="text-uppercase text-muted d-block" style="font-size: 0.65rem;">
                                                    Reviews available after completion
                                                </small>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
