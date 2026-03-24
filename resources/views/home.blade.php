@extends('layouts.app')

@section('content')
<style>
    /* Hero Title Styling */
    .shop-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 2.5rem;
        letter-spacing: -1px;
        margin-bottom: 40px;
    }

    /* Neubrutalist Card */
    .card-retro {
        background-color: #fff;
        border: 3px solid #000;
        border-radius: 0 !important;
        box-shadow: 10px 10px 0px 0px #000;
        transition: all 0.2s ease;
        overflow: hidden;
    }

    .card-retro:hover {
        transform: translate(-3px, -3px);
        box-shadow: 13px 13px 0px 0px #000;
    }

    /* Product Image */
    .card-img-retro {
        border-bottom: 3px solid #000;
        border-radius: 0 !important;
        height: 220px;
        object-fit: cover;
        background-color: #f0f0f0;
    }

    /* Typography */
    .product-name {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 1.1rem;
        margin-bottom: 8px;
        line-height: 1.1;
    }

    .price-tag-retro {
        display: inline-block;
        background-color: #ffff00; /* Neon Yellow */
        color: #000;
        padding: 5px 10px;
        font-weight: 900;
        border: 2px solid #000;
        margin-bottom: 20px;
        width: fit-content;
    }

    /* Buttons */
    .btn-retro {
        border: 2px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 10px;
        transition: all 0.1s;
        box-shadow: 4px 4px 0px 0px #000;
        text-decoration: none;
        display: block;
        text-align: center;
        color: #000;
    }

    .btn-retro:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    .btn-details { background-color: #fff; margin-bottom: 12px; }
    .btn-cart { background-color: #00ff00; } /* Neon Green */

    /* Empty State */
    .empty-retro {
        border: 4px dashed #000;
        padding: 50px;
        text-align: center;
        font-weight: 900;
        text-transform: uppercase;
    }

    /* Pagination Customization */
    .pagination .page-item .page-link {
        border: 2px solid #000;
        border-radius: 0;
        color: #000;
        font-weight: 900;
        margin: 0 5px;
        box-shadow: 3px 3px 0px 0px #000;
    }
</style>

<div class="container py-5">
    <h2 class="shop-title">Available Products.</h2>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card card-retro h-100">
                    <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
                         class="card-img-retro w-100"
                         alt="{{ $product->name }}">

                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="product-name">{{ $product->name }}</h5>

                        <div class="price-tag-retro">
                            ₱{{ number_format($product->price, 2) }}
                        </div>

                        <a href="{{ route('products.show', $product->id) }}"
                           class="btn-retro btn-details">
                            View Details
                        </a>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn-retro btn-cart w-100">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-retro">
                    <p class="text-muted mb-0">No products available at the moment.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
