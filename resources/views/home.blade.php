@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Available Products</h2>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Product Image -->
                    <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
     class="card-img-top"
     alt="{{ $product->name }}">



                    <!-- Product Details -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text mb-2">₱{{ number_format($product->price, 2) }}</p>

                        <!-- View Details -->
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="btn btn-sm btn-outline-primary mb-2">
                            View Details
                        </a>

                        <!-- Add to Cart -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No products available at the moment.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection
