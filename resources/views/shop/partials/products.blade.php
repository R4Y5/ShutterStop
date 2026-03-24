<style>
    /* Card Container */
    .card-retro {
        background-color: #fff;
        border: 3px solid #000;
        border-radius: 0 !important; /* Sharp corners */
        box-shadow: 8px 8px 0px 0px #000;
        transition: all 0.2s ease;
        overflow: hidden;
    }

    .card-retro:hover {
        transform: translate(-2px, -2px);
        box-shadow: 12px 12px 0px 0px #000;
    }

    /* Image Styling */
    .card-img-retro {
        border-bottom: 3px solid #000;
        border-radius: 0 !important;
        height: 200px;
        object-fit: cover;
        background-color: #f0f0f0;
    }

    /* Typography */
    .card-title-retro {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 1.1rem;
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .price-badge-retro {
        display: inline-block;
        background-color: #ffff00; /* Neon Yellow */
        color: #000;
        padding: 4px 8px;
        font-weight: 900;
        border: 2px solid #000;
        margin-bottom: 15px;
        width: fit-content;
    }

    /* Buttons */
    .btn-retro-sm {
        border: 2px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 8px 12px;
        transition: all 0.1s;
        box-shadow: 4px 4px 0px 0px #000;
        text-decoration: none;
        display: block;
        text-align: center;
        color: #000;
    }

    .btn-retro-sm:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    .btn-view { background-color: #fff; margin-bottom: 12px; }
    .btn-add-cart { background-color: #00ff00; border-width: 2px; } /* Neon Green */

    .empty-state-retro {
        border: 3px dashed #000;
        padding: 40px;
        text-align: center;
        font-weight: 900;
        text-transform: uppercase;
        background: #fff;
    }
</style>

<div class="row g-4">
    @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card-retro h-100">
                <!-- Product Image -->
                <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
                     class="card-img-retro w-100"
                     alt="{{ $product->name }}">

                <!-- Product Details -->
                <div class="card-body d-flex flex-column p-3">
                    <h5 class="card-title-retro">{{ $product->name }}</h5>

                    <div class="price-badge-retro">
                        ₱{{ number_format($product->price, 2) }}
                    </div>

                    <!-- View Details -->
                    <a href="{{ route('products.show', $product->id) }}" class="btn-retro-sm btn-view">
                        View Details
                    </a>

                    <!-- Add to Cart -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="btn-retro-sm btn-add-cart w-100">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state-retro">
                No products available in this category.
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-5 d-flex justify-content-center">
    {{ $products->links() }}
</div>
