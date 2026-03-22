@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Products</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
        <a href="/admin" class="btn btn-outline-secondary">Back to Admin Dashboard</a>
    </div>

    <div>
        <label for="categoryFilter" class="me-2">Filter by Category:</label>
        <select id="categoryFilter" class="form-select d-inline-block" style="width:200px;">
            <option value="">All Categories</option>
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="me-3">
            <label for="brandFilter" class="me-2">Filter by Brand:</label>
            <select id="brandFilter" class="form-select d-inline-block" style="width:200px;">
                <option value="">All Brands</option>
                @foreach(\App\Models\Product::select('brand')->distinct()->whereNotNull('brand')->get() as $brand)
                    <option value="{{ $brand->brand }}">{{ $brand->brand }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button id="resetFilters" class="btn btn-outline-secondary">Reset Filter</button>
        </div>

    <table id="products-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Photo</th>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
<script>
let table = $('#products-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{ route('products.data') }}',
        data: function (d) {
            d.category_id = $('#categoryFilter').val();
            d.brand = $('#brandFilter').val();
        }
    },
    columns: [
        { data: 'photo', name: 'photo', orderable: false, searchable: false },
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'brand', name: 'brand' },
        { data: 'category', name: 'category' },
        { data: 'description', name: 'description' },
        { data: 'price', name: 'price' },
        { data: 'stock', name: 'stock' },
        { data: 'created_at', name: 'created_at' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ],
    pageLength: 10,
    order: [[2, 'asc']],
    responsive: true
});

// Reload table when category filter changes
$('#categoryFilter, #brandFilter').change(function() {
    table.ajax.reload();
});

// Reset filters
$('#resetFilters').click(function() {
   $('#categoryFilter').val('');
   $('#brandFilter').val('');
   table.ajax.reload();
})
</script>
@endsection
