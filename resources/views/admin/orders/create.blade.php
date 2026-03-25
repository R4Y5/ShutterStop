@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Order</h2>

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <!-- Customer dropdown -->
        <div class="form-group mb-3">
            <label for="user_id">Customer Name</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Select Customer --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Product dropdown -->
        <div class="form-group mb-3">
            <label for="product_id">Item</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (₱{{ number_format($product->price, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Quantity field -->
        <div class="form-group mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <!-- Status dropdown -->
        <div class="form-group mb-3">
            <label for="status">Order Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">-- Select Status --</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <!-- Address field -->
        <div class="form-group mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control">
        </div>

        <!-- Remarks field -->
        <div class="form-group mb-3">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Order</button>
    </form>
</div>
@endsection
