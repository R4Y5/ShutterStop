@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Customer Orders</h2>

    <table class="table table-bordered">
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
                                'Pending' => 'badge bg-warning',
                                'Processing' => 'badge bg-info',
                                'Shipped' => 'badge bg-primary',
                                'Completed' => 'badge bg-success',
                                'Cancelled' => 'badge bg-danger',
                                default => 'badge bg-secondary',
                            };
                        @endphp
                        <span class="{{ $badgeClass }}">{{ $order->status }}</span>
                    </td>
                    <td>{{ $order->user->address }}</td>
                    <td>{{ $order->remarks }}</td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this order?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
