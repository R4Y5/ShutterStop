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

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.8rem;
        text-transform: uppercase;
        margin-bottom: 20px;
        letter-spacing: -1px;
        color: #000000;
        display: inline-block;
        padding: 5px 20px;
    }

    /* Alert Styling */
    .alert-retro {
        background-color: #00ff41;
        color: #000;
        border: 3px solid #000;
        padding: 15px;
        font-weight: bold;
        margin-bottom: 25px;
        box-shadow: 6px 6px 0px 0px #000;
        text-transform: uppercase;
    }

    /* Top Action Bar */
    .action-card {
        background: #fff;
        border: 4px solid #000;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 10px 10px 0px 0px #000;
    }

    /* Buttons */
    .btn-retro {
        border: 3px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 10px 20px;
        transition: all 0.1s;
        box-shadow: 5px 5px 0px 0px #000;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        color: #000;
    }
    .btn-retro:hover { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #000; color: #000; }
    .btn-primary-retro { background-color: #ffff00; }
    .btn-secondary-retro { background-color: #fff; }

    /* DataTables Controls */
    .dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 15px;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        padding: 8px !important;
        height: 45px !important;
        background: #fff !important;
        box-shadow: 4px 4px 0px #000;
        font-weight: bold;
        text-transform: uppercase;
    }

    .dataTables_wrapper .dataTables_filter input { width: 300px !important; }

    /* Table Styling */
    .table-wrapper-retro {
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        background: #fff;
        margin-bottom: 50px;
        padding: 20px;
        overflow-x: auto;
    }

    table.dataTable { border-collapse: collapse !important; border: 2px solid #000 !important; }
    table.dataTable thead th {
        background: #000 !important;
        color: #fff !important;
        text-transform: uppercase;
        padding: 15px !important;
    }

    table.dataTable tbody td {
        border-bottom: 1px solid #ddd !important;
        padding: 12px !important;
        font-weight: bold;
        vertical-align: middle !important;
    }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        background: #fff !important;
        font-weight: 900 !important;
        box-shadow: 3px 3px 0px #000;
        margin: 0 4px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #ffff00 !important;
        color: #000 !important;
        box-shadow: none !important;
        transform: translate(2px, 2px);
    }
</style>

<div class="container retro-container">
    <h1 class="page-title">All Reviews</h1>

    @if(session('success'))
        <div class="alert-retro">[SYSTEM_LOG]: {{ session('success') }}</div>
    @endif

    <div class="action-card">
        <a href="/admin" class="btn-retro btn-secondary-retro">Admin Dashboard</a>
    </div>

    <div class="table-wrapper-retro">
        <table id="reviews-table" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Initializing DataTable...');

    let table = $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        ajax: '{{ route('admin.reviews.data') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'product', name: 'product' },
            { data: 'user', name: 'user' },
            { data: 'rating', name: 'rating' },
            { data: 'comment', name: 'comment' },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data) {
                    return data ? data.split('T')[0] : '';
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[0, 'asc']],
        responsive: true,
        dom: '<"top"lf>rt<"bottom"ip><"clear">'
    });

    $(document).on('click', '.delete-review', function() {
        if(confirm('Are you sure you want to delete this review?')) {
            let id = $(this).data('id');
            $.ajax({
                url: '/admin/reviews/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() {
                    table.ajax.reload();
                    alert('Review deleted successfully');
                },
                error: function() {
                    alert('Failed to delete review');
                }
            });
        }
    });
});
</script>
@endpush