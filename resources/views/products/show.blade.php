@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist Product Page Styling */
    .product-container { padding: 60px 0; }

    .product-title-retro {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 3rem;
        letter-spacing: -2px;
        line-height: 0.9;
        margin-bottom: 20px;
        background: #000;
        color: #fff;
        display: inline-block;
        padding: 10px 20px;
    }

    /* Image Display Area */
    .main-photo-frame {
        border: 4px solid #000;
        box-shadow: 15px 15px 0px 0px #000;
        background: #fff;
        padding: 20px;
        margin-bottom: 30px;
    }

    .thumbnail-retro {
        border: 3px solid #000;
        transition: all 0.1s ease;
        filter: grayscale(100%);
    }

    .thumbnail-retro:hover {
        filter: grayscale(0%);
        transform: translate(-2px, -2px);
        box-shadow: 4px 4px 0px 0px #000;
    }

    /* Details Area */
    .details-box {
        border: 4px solid #000;
        padding: 30px;
        background: #fff;
        box-shadow: 10px 10px 0px 0px #ffff00; /* Neon Yellow Shadow */
    }

    .price-tag {
        font-size: 2.5rem;
        font-weight: 900;
        color: #000;
        margin-bottom: 15px;
        display: block;
    }

    .meta-label {
        text-transform: uppercase;
        font-weight: 900;
        font-size: 0.8rem;
        background: #eee;
        padding: 2px 8px;
        border: 1px solid #000;
    }

    /* Add to Cart Button */
    .btn-add-cart {
        background: #00ff41; /* Neon Green */
        color: #000;
        border: 3px solid #000;
        padding: 15px 30px;
        font-weight: 900;
        text-transform: uppercase;
        width: 100%;
        margin-top: 20px;
        box-shadow: 6px 6px 0px 0px #000;
        transition: 0.1s;
    }

    .btn-add-cart:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        background: #000;
        color: #00ff41;
    }

    /* Review Styling */
    .review-card {
        border: 3px solid #000;
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 5px 5px 0px 0px #000;
    }

    .review-header {
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .star-rating { font-size: 1.2rem; }
</style>

<div class="container product-container">
    <h2 class="product-title-retro">{{ $product->name }}</h2>

    <div class="row g-5">
        <div class="col-md-7">
            <div class="main-photo-frame">
                <img id="mainPhoto"
                     src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
                     alt="{{ $product->name }}"
                     style="width:100%; height:500px; object-fit:contain;">
            </div>

            @if($product->photos->count() > 1)
                <div class="d-flex flex-wrap mt-3">
                    @foreach($product->photos as $photo)
                        <div class="me-3 mb-3">
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

        <div class="col-md-5">
            <div class="details-box">
                <span class="price-tag">₱{{ number_format($product->price, 2) }}</span>
                <p class="mb-4" style="font-size: 1.1rem; line-height: 1.6;">{{ $product->description }}</p>

                <div class="mb-3">
                    <span class="meta-label">Brand</span> <strong>{{ $product->brand }}</strong>
                </div>
                <div class="mb-4">
                    <span class="meta-label">Availability</span> <strong>{{ $product->stock }} IN STOCK</strong>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-add-cart">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-5">
        <h4 class="text-uppercase fw-900 mb-4" style="letter-spacing: 2px; border-bottom: 4px solid #000; display: inline-block;">
            Customer Reviews
        </h4>

        <div class="mt-4">
            @forelse($product->reviews as $review)
                <div class="review-card">
                    <div class="review-header d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-uppercase">{{ $review->user->first_name }} {{ $review->user->last_name }}</strong>
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <span class="text-warning">&#9733;</span>
                                    @else
                                        <span class="text-secondary">&#9734;</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <span class="small font-weight-bold text-muted">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <p class="mb-0 mt-2 italic">"{{ $review->comment }}"</p>
                </div>
            @empty
                <div class="p-4 border border-dark text-center bg-light">
                    <p class="mb-0 text-uppercase font-weight-bold">No feedback yet. Be the first to review!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function switchPhoto(newSrc) {
    const mainPhoto = document.getElementById('mainPhoto');
    mainPhoto.src = newSrc;
    // Maintained the consistent sizing logic
    mainPhoto.style.width = "100%";
    mainPhoto.style.height = "500px";
    mainPhoto.style.objectFit = "contain";
}
</script>
@endsection
