@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist Layout Base */
    body {
        background-color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        background-image: linear-gradient(#d0d0d0 1px, transparent 1px), linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .retro-container { padding: 40px 20px; }
    .page-title { font-family: 'Inter', sans-serif; font-weight: 900; font-size: 2.8rem; text-transform: uppercase; margin-bottom: 20px; letter-spacing: -1px; }

    /* Alert Styling */
    .alert-retro { background-color: #00ff41; color: #000; border: 3px solid #000; padding: 15px; font-weight: bold; margin-bottom: 25px; box-shadow: 6px 6px 0px 0px #000; text-transform: uppercase; }

    /* Action Card */
    .action-card { background: #fff; border: 4px solid #000; padding: 25px; margin-bottom: 30px; box-shadow: 10px 10px 0px 0px #000; }
    .form-control-retro { border: 2px solid #000 !important; border-radius: 0 !important; font-weight: bold; text-transform: uppercase; font-size: 0.8rem; padding: 8px; }

    /* Buttons */
    .btn-retro { border: 3px solid #000; border-radius: 0; font-weight: 900; text-transform: uppercase; font-size: 0.85rem; padding: 10px 20px; transition: all 0.1s; box-shadow: 5px 5px 0px 0px #000; text-decoration: none; display: inline-block; cursor: pointer; color: #000; }
    .btn-retro:hover { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #000; }

    /* DATA TABLES ALIGNMENT FIX */
    .dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 20px;
    }

    /* Style both Show Entries and Search Bar identically */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin: 0 !important;
        float: none !important;
        display: flex;
        align-items: center;
        font-weight: 900;
        text-transform: uppercase;
    }

    /* Make the inputs the same height and style */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        padding: 10px !important;
        height: 45px !important; /* Uniform Height */
        background: #fff !important;
        box-shadow: 4px 4px 0px #000;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 300px !important;
        margin-left: 15px !important;
    }

    .dataTables_wrapper .dataTables_length select {
        width: 80px !important;
        margin: 0 10px !important;
    }

    /* Table & Wrapper */
    .table-wrapper-retro { border: 4px solid #000; box-shadow: 12px 12px 0px 0px #000; background: #fff; margin-bottom: 50px; padding: 20px; }
    table.dataTable { width: 100% !important; margin: 10px 0 !important; border: 2px solid #000 !important; }
    table.dataTable thead th { background: #000 !important; color: #fff !important; text-transform: uppercase; padding: 15px !important; }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        background: #fff !important;
        font-weight: bold !important;
        box-shadow: 2px 2px 0px #000;
        margin: 0 3px !important;
    }

    .trash-title { background: #ff3e3e; color: #fff; display: inline-block; padding: 5px 15px; font-weight: 900; text-transform: uppercase; margin-bottom: 15px; border: 3px solid #000; }
</style>

<div class="container-fluid retro-container">
    <h1 class="page-title">Manage Products</h1>

    @if(session('success'))
        <div class="alert-retro">[SYSTEM_LOG]: {{ session('success') }}</div>
    @endif

    <div class="action-card">
        <div class="row align-items-end g-3">
            <div class="col-12 mb-3">
                <a href="{{ route('admin.products.create') }}" class="btn-retro btn-primary-retro me-2" style="background:#ffff00;">Add New Product +</a>
                <a href="/admin" class="btn-retro btn-secondary-retro" style="background:#fff;">Dashboard</a>
            </div>

            <div class="col-md-4 border-end border-dark pe-md-4">
                <label>Bulk Import (.xlsx)</label>
                <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="file" class="form-control form-control-retro" required>
                        <button class="btn-retro" type="submit" style="background:#00ff41; box-shadow: 3px 3px 0px 0px #000;">Import</button>
                    </div>
                </form>
            </div>

            <div class="col-md-3 ps-md-4">
                <label>Category</label>
                <select id="categoryFilter" class="form-control form-control-retro">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Brand</label>
                <select id="brandFilter" class="form-control form-control-retro">
                    <option value="">All Brands</option>
                    <option value="Sony">Sony</option>
                    <option value="Canon">Canon</option>
                    <option value="Nikon">Nikon</option>
                </select>
            </div>

            <div class="col-md-2">
                <button id="resetFilters" class="btn-retro w-100" style="background:#fff;">Reset Filter</button>
            </div>
        </div>
    </div>

    <div class="table-wrapper-retro">
        <table id="products-table" class="table">
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
                    <th>Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="trash-title">Recycle Bin / Trash</div>

    <div class="table-wrapper-retro" style="box-shadow: 12px 12px 0px 0px #000;">
        <table id="trashed-products-table" class="table">
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
                    <th>DeletedAt</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let table = $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.products.data') }}',
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
        responsive: true,
        // This 'dom' configuration forces 'length' and 'filter' into a container named 'top'
        dom: '<"top"lf>rt<"bottom"ip><"clear">'
    });

    let trashedTable = $('#trashed-products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: '{{ route('admin.products.trashed.data') }}' },
        columns: [
            { data: 'photo', name: 'photo', orderable: false, searchable: false },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'brand', name: 'brand' },
            { data: 'category', name: 'category' },
            { data: 'description', name: 'description' },
            { data: 'price', name: 'price' },
            { data: 'stock', name: 'stock' },
            { data: 'deleted_at', name: 'deleted_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        responsive: true,
        dom: '<"top"lf>rt<"bottom"ip><"clear">'
    });

    $('#categoryFilter, #brandFilter').change(function() { table.ajax.reload(); });
    $('#resetFilters').click(function() {
       $('#categoryFilter').val('');
       $('#brandFilter').val('');
       table.ajax.reload();
    });
</script>
@endpush
