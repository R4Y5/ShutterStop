@extends('layouts.app')

@section('content')
<style>
    /* Global Neubrutalist touches */
    .product-container { padding-top: 50px; padding-bottom: 50px; }

    /* Alert Styling */
    .alert-retro {
        background-color: #000;
        color: #fff;
        border-radius: 0;
        border: none;
        font-weight: 900;
        text-transform: uppercase;
        box-shadow: 6px 6px 0px 0px #ccc;
        margin-bottom: 30px;
    }

    /* Photo Section */
    .main-photo-wrapper {
        background-color: #fff;
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .thumbnail-retro {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        box-shadow: 4px 4px 0px 0px #000;
        transition: transform 0.1s;
        padding: 0;
    }

    .thumbnail-retro:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
    }

    /* Details Section */
    .product-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 2.5rem;
        line-height: 1;
        margin-bottom: 15px;
    }

    .price-tag {
        display: inline-block;
        background-color: #ffff00; /* Neon Yellow */
        color: #000;
        padding: 10px 20px;
        font-weight: 900;
        font-size: 1.5rem;
        border: 3px solid #000;
        box-shadow: 6px 6px 0px 0px #000;
        margin-bottom: 25px;
    }

    .info-box {
        background: #f3f3f3;
        border: 2px solid #000;
        padding: 20px;
        margin-bottom: 25px;
    }

    /* Form Controls */
    .form-control-retro {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        font-weight: 900;
        padding: 10px;
    }

    .btn-add-cart {
        background-color: #00ff00 !important; /* Neon Green */
        color: #000 !important;
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        font-weight: 900;
        text-transform: uppercase;
        padding: 15px 30px;
        box-shadow: 6px 6px 0px 0px #000;
        transition: all 0.2s;
    }

    .btn-add-cart:hover {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px 0px #000;
    }

    /* Reviews */
    .review-card {
        background: #fff;
        border: 3px solid #000;
        box-shadow: 8px 8px 0px 0px #000;
        padding: 20px;
        margin-bottom: 20px;
    }

    .review-header {
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .star-icon { font-size: 1.2rem; }
</style>

<div class="container product-container">
    @if(session('success'))
        <div class="alert alert-retro text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-5">
        <div class="col-md-6">
            <div class="main-photo-wrapper" style="height: 500px; width: 100%;">
                <img id="mainPhoto"
                     src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
                     alt="{{ $product->name }}"
                     style="max-width:90%; max-height:90%; object-fit:contain;">
            </div>

            @if($product->photos->count() > 1)
                <div class="d-flex flex-wrap justify-content-start mt-3">
                    @foreach($product->photos as $photo)
                        <div class="m-2">
                            <img src="{{ asset('storage/' . $photo->path) }}"
                                 class="thumbnail-retro"
                                 alt="{{ $product->name }}"
                                 style="width:80px; height:80px; object-fit:cover; cursor:pointer;"
                                 onclick="switchPhoto('{{ asset('storage/' . $photo->path) }}')">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h2 class="product-title">{{ $product->name }}</h2>

            <div class="price-tag">
                ₱{{ number_format($product->price, 2) }}
            </div>

            <div class="info-box">
                <p class="lead fw-bold">{{ $product->description }}</p>
                <hr style="border-top: 2px solid #000; opacity: 1;">
                <p class="mb-1"><strong>BRAND:</strong> {{ strtoupper($product->brand) }}</p>
                <p class="mb-0"><strong>AVAILABILITY:</strong> {{ $product->stock }} UNITS IN STOCK</p>
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="d-flex align-items-end">
                    <div class="me-3">
                        <label for="quantity" class="fw-black text-uppercase small d-block mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control form-control-retro" style="width:120px;">
                    </div>
                    <button type="submit" class="btn btn-add-cart">
                        Add to Bag.
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 pt-5">
        <h4 class="fw-black text-uppercase mb-4" style="letter-spacing: 2px; border-left: 8px solid #000; padding-left: 15px;">
            Customer Feedback
        </h4>

        <div class="row">
            <div class="col-lg-8">
                @forelse($product->reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <h6 class="mb-0 fw-black text-uppercase">{{ $review->user->first_name }} {{ $review->user->last_name }}</h6>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <span class="text-warning star-icon">&#9733;</span>
                                    @else
                                        <span class="text-secondary star-icon">&#9734;</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="mb-0 fw-bold" style="font-size: 1.1rem;">"{{ $review->comment }}"</p>
                    </div>
                @empty
                    <div class="info-box text-center">
                        <p class="text-muted mb-0 fw-bold">NO REVIEWS YET. BE THE FIRST TO SHARE YOUR THOUGHTS!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function switchPhoto(newSrc) {
    document.getElementById('mainPhoto').src = newSrc;
}
</script>
@endsection
