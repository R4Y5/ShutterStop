@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Write a Review for {{ $product->name }}</h2>

    <form action="{{ route('products.review', $product->id) }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="mb-3">
            <label>Rating</label>
            <select name="rating" class="form-select" required>
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label>Comment</label>
            <textarea name="comment" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Review</button>
    </form>
</div>
@endsection
