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

    .retro-container {
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

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

    /* Form Card */
    .form-card {
        background: #fff;
        border: 4px solid #000;
        padding: 35px;
        box-shadow: 12px 12px 0px 0px #000;
        width: 100%;
        max-width: 700px;
        margin-bottom: 50px;
    }

    /* Form Groups */
    .form-group-retro {
        margin-bottom: 24px;
    }

    .form-group-retro label {
        display: block;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin-bottom: 8px;
        color: #000;
    }

    .form-control-retro {
        width: 100%;
        border: 3px solid #000;
        border-radius: 0;
        padding: 10px 14px;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 0.95rem;
        background: #fff;
        box-shadow: 4px 4px 0px #000;
        transition: all 0.1s;
        appearance: none;
        -webkit-appearance: none;
        box-sizing: border-box;
    }

    .form-control-retro:focus {
        outline: none;
        box-shadow: 0px 0px 0px #000;
        transform: translate(2px, 2px);
        background: #fffde7;
    }

    textarea.form-control-retro {
        resize: vertical;
        min-height: 100px;
    }

    /* Select arrow */
    select.form-control-retro {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23000' stroke-width='2' fill='none'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
        cursor: pointer;
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
        font-family: 'Courier New', Courier, monospace;
    }
    .btn-retro:hover { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #000; color: #000; }
    .btn-primary-retro { background-color: #ffff00; }
    .btn-secondary-retro { background-color: #fff; }
    .btn-secondary-retro:hover {
        background-color: #ffff00; /* Neon Yellow on hover */
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    /* Action bar */
    .action-card {
        background: #fff;
        border: 4px solid #000;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 10px 10px 0px 0px #000;
        width: 100%;
        max-width: 700px;
    }

    /* Validation errors */
    .error-retro {
        background-color: #ff4d4d;
        color: #fff;
        border: 3px solid #000;
        padding: 15px;
        font-weight: bold;
        margin-bottom: 25px;
        box-shadow: 6px 6px 0px 0px #000;
        text-transform: uppercase;
        width: 100%;
        max-width: 700px;
    }

    .field-error {
        color: #ff4d4d;
        font-weight: 900;
        font-size: 0.8rem;
        text-transform: uppercase;
        margin-top: 5px;
        display: block;
    }

    .form-control-retro.is-invalid {
        border-color: #ff4d4d;
        box-shadow: 4px 4px 0px #ff4d4d;
    }
</style>

<div class="container-fluid retro-container">
    <h1 class="page-title">Create New Order</h1>

    @if($errors->any())
        <div class="error-retro">
            [ERROR]: Please fix the following —
            <ul style="margin: 8px 0 0 16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="action-card">
        <a href="{{ route('admin.orders.index') }}" class="btn-retro btn-secondary-retro">← Back to Orders</a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf

            <!-- Customer -->
            <div class="form-group-retro">
                <label for="user_id">Customer Name</label>
                <select name="user_id" id="user_id" class="form-control-retro @error('user_id') is-invalid @enderror" required>
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->first_name }} {{ $customer->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Product -->
            <div class="form-group-retro">
                <label for="product_id">Item</label>
                <select name="product_id" id="product_id" class="form-control-retro @error('product_id') is-invalid @enderror" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (₱{{ number_format($product->price, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('product_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Quantity -->
            <div class="form-group-retro">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity"
                    class="form-control-retro @error('quantity') is-invalid @enderror"
                    min="1" value="{{ old('quantity') }}" required>
                @error('quantity') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div class="form-group-retro">
                <label for="status">Order Status</label>
                <select name="status" id="status" class="form-control-retro @error('status') is-invalid @enderror" required>
                    <option value="">-- Select Status --</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Address -->
            <div class="form-group-retro">
                <label for="address">Address</label>
                <input type="text" name="address" id="address"
                    class="form-control-retro @error('address') is-invalid @enderror"
                    value="{{ old('address') }}">
                @error('address') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Remarks -->
            <div class="form-group-retro">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" id="remarks"
                    class="form-control-retro @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                @error('remarks') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-retro btn-primary-retro mt-2">Create Order</button>
        </form>
    </div>
</div>
@endsection