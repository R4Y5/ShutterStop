@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Reviews</h2>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($reviews->isEmpty())
        <p class="text-muted">You haven’t written any reviews yet.</p>
    @else
        @foreach($reviews as $review)
            <div class="border p-3 mb-3">
                <h5 class="mb-1">{{ $review->product->name }}</h5>
                <span class="text-muted">Rated {{ $review->rating }}/5 on {{ $review->created_at->format('M d, Y') }}</span>
                <p class="mt-2">{{ $review->comment }}</p>

                <a href="{{ route('products.review.form', $review->product->id) }}" 
                   class="btn btn-sm btn-warning">Edit Review</a>
                <a href="{{ route('products.show', $review->product->id) }}" 
                   class="btn btn-sm btn-outline-primary">View Product</a>
            </div>
        @endforeach

        {{-- Pagination if needed --}}
        <div class="mt-3">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
