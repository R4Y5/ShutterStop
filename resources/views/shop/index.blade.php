@extends('layouts.app')

@section('content')
<style>
    /* Hero Title */
    .hero-text h2 {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.8rem;
        text-transform: uppercase;
        margin-bottom: 35px;
        text-align: center;
    }

    /* Filter Bar Container */
    .filter-wrapper {
        background-color: #fff;
        border: 3px solid #000;
        box-shadow: 10px 10px 0px 0px #000;
        padding: 25px;
        margin-bottom: 40px;
    }

    /* Labels */
    .filter-label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.75rem;
        margin-bottom: 5px;
        display: block;
    }

    /* Form Inputs & Selects */
    .form-control, .form-select {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        padding: 10px;
        background-color: #fff;
        font-weight: bold;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 4px 4px 0px 0px #000;
        border-color: #000;
        outline: none;
    }

    /* Buttons */
    .btn-retro {
        border: 2px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        padding: 10px;
        transition: all 0.1s;
        box-shadow: 4px 4px 0px 0px #000;
        font-size: 0.8rem;
    }

    .btn-retro:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
    }

    .btn-filter { background-color: #00ff00; color: #000; } /* Neon Green */
    .btn-clear { background-color: #fff; color: #000; }

    /* Pagination Styling */
    .pagination .page-item .page-link {
        border: 2px solid #000;
        color: #000;
        font-weight: 900;
        margin: 0 3px;
        box-shadow: 3px 3px 0px 0px #000;
    }

    .pagination .page-item.active .page-link {
        background-color: #000;
        border-color: #000;
        color: #fff;
        box-shadow: none;
        transform: translate(2px, 2px);
    }
</style>

<div class="container py-5">
    <div class="hero-text">
        <h2>Shop Products</h2>
    </div>

    <div class="filter-wrapper">
        <form id="filterForm" method="GET" action="{{ route('shop.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="filter-label">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Type here...">
            </div>

            <div class="col-md-2">
                <label class="filter-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="filter-label">Brand</label>
                <select name="brand" class="form-select">
                    <option value="">All Brands</option>
            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                    {{ $brand }}
                </option>
            @endforeach
                </select>
            </div>

            <div class="col-md-1">
                <label class="filter-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">All</option>
                    <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Product</option>
                </select>
            </div>

            <div class="col-md-1">
                <label class="filter-label">Min</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="0">
            </div>

            <div class="col-md-1">
                <label class="filter-label">Max</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="9000">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <div class="w-100 d-flex gap-2">
                    <button type="submit" class="btn btn-retro btn-filter flex-grow-1">Filter</button>
                    <button type="button" id="clearFilters" class="btn btn-retro btn-clear flex-grow-1">Clear</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Product Listing -->
    <div id="productList">
        @include('shop.partials.products', ['products' => $products])
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>

<script>
    // Clear filters
    document.getElementById('clearFilters').addEventListener('click', function() {
        const form = document.getElementById('filterForm');
        form.reset();
        window.location.href = form.action; // reload page without filters
    });
</script>
@endsection
