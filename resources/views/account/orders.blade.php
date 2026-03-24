@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Status</th>
                <th>Total</th>
                <th>Date</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>₱{{ number_format($order->total, 2) }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        @foreach($order->items as $item)
                            • {{ $item->product->name }} (x{{ $item->quantity }})

                            @php
                                $review = $item->product->reviews()
                                    ->where('user_id', auth()->id())
                                    ->where('order_id', $order->id)
                                    ->first();
                            @endphp

                            @if(strtolower($order->status) === 'completed')
                                @if($review)
                                    <!-- Link to edit review -->
                                    <a href="{{ route('account.reviews.edit', $review->id) }}" 
                                       class="btn btn-warning btn-sm mt-2">
                                        Update Review
                                    </a>
                                @else
                                    <!-- New Review Form -->
                                    <a href="{{ route('products.review.form', $item->product->id) }}?order_id={{ $order->id }}"
                                       class="btn btn-success btn-sm mt-2">
                                        Write Review
                                    </a>
                                @endif
                            @else
                                <p class="text-muted">Reviews available only after order is completed.</p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-muted">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
