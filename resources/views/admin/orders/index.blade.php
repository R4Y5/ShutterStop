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
    .btn-danger-retro  { background-color: #ff4d4d; color: #fff; }
    .btn-danger-retro:hover { color: #fff; }

    /* Table Styling */
    .table-wrapper-retro {
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        background: #fff;
        margin-bottom: 50px;
        padding: 20px;
        overflow-x: auto;
    }

    .table-retro {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #000;
    }

    .table-retro thead th {
        background: #000;
        color: #fff;
        text-transform: uppercase;
        padding: 15px;
        font-weight: 900;
        letter-spacing: 0.5px;
    }

    .table-retro tbody td {
        border-bottom: 1px solid #ddd;
        padding: 12px;
        font-weight: bold;
        vertical-align: middle;
    }

    .table-retro tbody tr:hover {
        background-color: #fffde7;
    }

    /* Status Badges */
    .badge-retro {
        display: inline-block;
        padding: 4px 10px;
        border: 2px solid #000;
        font-weight: 900;
        font-size: 0.75rem;
        text-transform: uppercase;
        box-shadow: 3px 3px 0px #000;
    }
    .badge-pending    { background-color: #ffe066; color: #000; }
    .badge-processing { background-color: #66d9ff; color: #000; }
    .badge-shipped    { background-color: #66aaff; color: #000; }
    .badge-completed  { background-color: #00ff41; color: #000; }
    .badge-cancelled  { background-color: #ff4d4d; color: #fff; }
    .badge-default    { background-color: #ccc;    color: #000; }

    /* Pagination */
    .pagination-retro {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .pagination-retro li a,
    .pagination-retro li span {
        display: inline-block;
        padding: 8px 14px;
        border: 2px solid #000;
        font-weight: 900;
        text-decoration: none;
        color: #000;
        background: #fff;
        box-shadow: 3px 3px 0px #000;
        transition: all 0.1s;
    }
    .pagination-retro li.active span {
        background: #ffff00;
        box-shadow: none;
        transform: translate(2px, 2px);
    }
    .pagination-retro li a:hover {
        transform: translate(2px, 2px);
        box-shadow: none;
        color: #000;
    }
    .pagination-retro li.disabled span {
        opacity: 0.4;
        box-shadow: none;
    }
</style>

<div class="container-fluid retro-container">
    <h1 class="page-title">All Customer Orders</h1>

    @if(session('success'))
        <div class="alert-retro">[SYSTEM_LOG]: {{ session('success') }}</div>
    @endif

    <div class="action-card">
        <a href="{{ route('admin.orders.create') }}" class="btn-retro btn-primary-retro me-2">+ Create New Order</a>
        <a href="/admin" class="btn-retro btn-secondary-retro">Admin Dashboard</a>
    </div>

    <div class="table-wrapper-retro">
        <table class="table-retro">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>
                            @php
                                $badgeClass = match($order->status) {
                                    'Pending'    => 'badge-pending',
                                    'Processing' => 'badge-processing',
                                    'Shipped'    => 'badge-shipped',
                                    'Completed'  => 'badge-completed',
                                    'Cancelled'  => 'badge-cancelled',
                                    default      => 'badge-default',
                                };
                            @endphp
                            <span class="badge-retro {{ $badgeClass }}">{{ $order->status }}</span>
                        </td>
                        <td>{{ $order->user->address }}</td>
                        <td>{{ $order->remarks }}</td>
                        <td>
                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn-retro btn-primary-retro" style="font-size:0.75rem; padding:6px 12px;">Edit</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-retro btn-danger-retro" style="font-size:0.75rem; padding:6px 12px;"
                                    onclick="return confirm('Are you sure you want to delete this order?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <nav>
            <ul class="pagination-retro">
                {{ $orders->links() }}
            </ul>
        </nav>
    </div>
</div>
@endsection