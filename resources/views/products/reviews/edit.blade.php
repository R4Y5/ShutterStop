@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Review for {{ $review->product->name }}</h2>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Rating</label>
            <select name="rating" class="form-select">
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label>Comment</label>
            <textarea name="comment" class="form-control">{{ $review->comment }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Update Review</button>
    </form>
</div>
@endsection
