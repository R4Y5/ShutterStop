@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Orders</h2>

    @if($orders->isEmpty())
        <p class="text-muted">You have no orders yet.</p>
    @else
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
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>₱{{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <ul>
                                @foreach($order->items as $item)
                        <li>
                            {{ $item->product->name }} (x{{ $item->quantity }})

                            @if(strtolower($order->status) === 'completed')
                                @php
                                    $existingReview = $item->product->reviews()
                                        ->where('user_id', auth()->id())
                                        ->first();
                                @endphp

                                @if($existingReview)
                                    <a href="{{ route('products.review.form', $item->product->id) }}"
                                    class="btn btn-sm btn-warning ms-2">Edit Review</a>
                                @else
                                    <a href="{{ route('products.review.form', $item->product->id) }}"
                                    class="btn btn-sm btn-success ms-2">Write Review</a>
                                @endif
                            @endif
                        </li>
                    @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
