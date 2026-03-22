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

    <table id="products-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Photo</th>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
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
    $('#products-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('products.data') }}',
    columns: [
        { data: 'photo', name: 'photo', orderable: false, searchable: false },
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'brand', name: 'brand' },
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
</script>
@endsection
