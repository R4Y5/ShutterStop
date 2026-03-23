@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Shop Products</h2>

    <!-- Search + Filter -->
    <form id="filterForm" method="GET" action="{{ route('shop.index') }}" class="row mb-4">
    <!-- Search -->
    <div class="col-md-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search products...">
    </div>

    <!-- Category -->
    <div class="col-md-2">
        <select name="category" class="form-select">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Brand -->
    <div class="col-md-2">
        <select name="brand" class="form-select">
            <option value="">All Brands</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Type -->
    <div class="col-md-2">
        <select name="type" class="form-select">
            <option value="">All Types</option>
            <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Service</option>
            <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Product</option>
        </select>
    </div>

    <!-- Price Range -->
    <div class="col-md-1">
        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="Min">
    </div>
    <div class="col-md-1">
        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="Max">
    </div>

    <!-- Filter Button -->
    <div class="col-md-1 d-flex flex-column">
    <button type="submit" class="btn btn-primary w-100 mb-2">Filter</button>
    <button type="button" id="clearFilters" class="btn btn-secondary w-100">Clear</button>
</div>
</form>


<!-- Product Listing -->
<div id="productList">
    @include('shop.partials.products', ['products' => $products])
</div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const inputs = form.querySelectorAll('input, select');

    // Auto-submit on change
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            submitFilters();
        });
    });

    // Clear filters
    document.getElementById('clearFilters').addEventListener('click', function() {
        form.reset(); // ✅ resets search, min/max, category, brand, type

        // reload products without filters
        let url = form.action; // no query params
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('productList').innerHTML = html;
        })
        .catch(err => console.error(err));
    });

    function submitFilters() {
        let url = form.action + '?' + new URLSearchParams(new FormData(form)).toString();

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('productList').innerHTML = html;
        })
        .catch(err => console.error(err));
    }
});
</script>
@endsection



