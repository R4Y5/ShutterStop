@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Review {{ $product->name }}</h2>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Review Form --}}
    <form action="{{ route('products.review', $product->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <select name="rating" id="rating" class="form-select" required>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" 
                        {{ isset($review) && $review->rating == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea name="comment" id="comment" class="form-control" rows="4">{{ $review->comment ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($review) ? 'Update Review' : 'Submit Review' }}
        </button>
        <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary">Back to My Orders</a>
    </form>
</div>
@endsection
