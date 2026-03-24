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
                            <div class="mb-3">
                                • {{ $item->product->name }} (x{{ $item->quantity }})

                                @php
                                    $review = $item->product->reviews()
                                        ->where('user_id', auth()->id())
                                        ->where('order_id', $order->id)
                                        ->first();
                                @endphp

                                @if($review)
                                    {{-- Edit Review Form --}}
                                    <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-2">
                                            <label>Rating</label>
                                            <select name="rating" class="form-select">
                                                @for($i=1;$i<=5;$i++)
                                                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label>Comment</label>
                                            <textarea name="comment" class="form-control">{{ $review->comment }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-warning btn-sm">Update Review</button>
                                    </form>
                                @else
                                    {{-- New Review Form --}}
                                    <form action="{{ route('products.review', $item->product->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                        <div class="mb-2">
                                            <label>Rating</label>
                                            <select name="rating" class="form-select" required>
                                                @for($i=1;$i<=5;$i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label>Comment</label>
                                            <textarea name="comment" class="form-control"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm">Submit Review</button>
                                    </form>
                                @endif
                            </div>
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
