@extends('layouts.app')

@section('content')
<style>
    /* Hero Title */
    .hero-text h1 {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        line-height: 1.1;
        margin-bottom: 30px;
        text-align: center;
        text-transform: uppercase;
    }

    /* Success/Error Messages - Matched to Security Page */
    .alert-retro-success {
        background-color: #000;
        color: #fff;
        border-radius: 0;
        border: none;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        box-shadow: 6px 6px 0px 0px #ccc; /* Subtle shadow for contrast on white */
    }

    .alert-retro-danger {
        background-color: #ff0000;
        color: #fff;
        border-radius: 0;
        border: 3px solid #000;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        box-shadow: 6px 6px 0px 0px #000;
    }

    /* Review Card Styling - Matched to Card in Security */
    .review-card {
        background-color: #fff;
        border: 3px solid #000;
        border-radius: 0;
        box-shadow: 8px 8px 0px 0px #000;
        padding: 25px;
        margin-bottom: 35px;
        transition: all 0.2s;
    }

    .review-card:hover {
        transform: translate(-2px, -2px);
        box-shadow: 10px 10px 0px 0px #000;
    }

    .product-title {
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 10px;
        font-size: 1.25rem;
    }

    /* Rating Badge */
    .rating-badge {
        background-color: #ffff00; /* Retro Yellow */
        color: #000;
        border: 2px solid #000;
        font-weight: 900;
        padding: 4px 12px;
        display: inline-block;
        text-transform: uppercase;
        font-size: 0.8rem;
        margin-right: 10px;
    }

    .review-date {
        font-size: 0.85rem;
        font-weight: bold;
        text-transform: uppercase;
        color: #000;
    }

    .review-comment {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        background: #f0f0f0;
        padding: 15px;
        border: 2px solid #000;
        margin: 20px 0;
        font-size: 1rem;
        position: relative;
    }

    /* Action Buttons - Matched to btn-retro */
    .btn-retro-sm {
        background-color: #fff;
        color: #000;
        border: 2px solid #000;
        border-radius: 0;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 10px 20px;
        transition: all 0.2s;
        box-shadow: 4px 4px 0px 0px #000;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }

    .btn-retro-sm:hover {
        background-color: #000;
        color: #fff !important;
        box-shadow: none;
        transform: translate(2px, 2px);
    }

    .btn-yellow { background-color: #ffff00; }

    /* Empty State */
    .empty-state {
        border: 4px dashed #000;
        padding: 60px;
        text-align: center;
        background: #fff;
        box-shadow: 8px 8px 0px 0px #eee;
    }

    .empty-state h4 {
        font-weight: 900;
        text-transform: uppercase;
    }
</style>

<div class="container py-5">
    <div class="hero-text">
        <h1>Reviews.</h1>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-retro-success text-center mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error') || $errors->any())
        <div class="alert alert-retro-danger mb-4">
            <ul class="mb-0 list-unstyled">
                @if(session('error')) <li>{{ session('error') }}</li> @endif
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($reviews->isEmpty())
                <div class="empty-state">
                    <h4 class="mb-0">You haven’t written any reviews yet.</h4>
                </div>
            @else
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="product-header">
                            <h5 class="product-title">{{ $review->product->name }}</h5>
                            <div class="mb-3">
                                <span class="rating-badge">RATING: {{ $review->rating }}/5</span>
                                <span class="review-date">DATE: {{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="review-comment">
                            "{{ $review->comment }}"
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('products.review.form', $review->product->id) }}"
                               class="btn-retro-sm btn-yellow">Edit Review</a>

                            <a href="{{ route('products.show', $review->product->id) }}"
                               class="btn-retro-sm">View Product</a>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                <div class="mt-5 d-flex justify-content-center">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
