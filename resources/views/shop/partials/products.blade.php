<div class="row">
    @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
                     class="card-img-top"
                     alt="{{ $product->name }}">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text mb-2">₱{{ number_format($product->price, 2) }}</p>

                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary mb-2">
                        View Details
                    </a>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted">No products available.</p>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $products->links() }}
</div>
