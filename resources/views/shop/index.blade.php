@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Shop Products</h2>

    <!-- Search + Filter -->
    <form method="GET" action="{{ route('shop.index') }}" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search products...">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="price" value="{{ request('price') }}" class="form-control" placeholder="Max Price">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

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
</div>
@endsection
