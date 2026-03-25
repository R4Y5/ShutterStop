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
        width: 100%;
        max-width: 700px;
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

    /* Form Card */
    .form-card {
        background: #fff;
        border: 4px solid #000;
        padding: 35px;
        box-shadow: 12px 12px 0px 0px #000;
        width: 100%;
        max-width: 700px;
        margin-bottom: 30px;
    }

    /* Section heading inside card */
    .section-heading {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 3px solid #000;
        padding-bottom: 8px;
        margin: 30px 0 20px;
    }

    /* Form Groups */
    .form-group-retro { margin-bottom: 24px; }

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

    .form-control-retro:disabled {
        background: #f0f0f0;
        cursor: not-allowed;
        opacity: 0.7;
        box-shadow: 2px 2px 0px #000;
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
        background: none;
    }
    .btn-retro:hover { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #000; color: #000; }
    .btn-primary-retro { background-color: #ffff00; }
    .btn-secondary-retro { background-color: #fff; }
    .btn-danger-retro { background-color: #ff4d4d; color: #fff; }
    .btn-danger-retro:hover { color: #fff; }

    .btn-retro:hover {
        background-color: #ffff00; /* Neon Yellow on hover */
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    /* Table Styling */
    .table-retro {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #000;
        margin-bottom: 10px;
    }

    .table-retro thead th {
        background: #000;
        color: #fff;
        text-transform: uppercase;
        padding: 12px 15px;
        font-weight: 900;
        letter-spacing: 0.5px;
    }

    .table-retro tbody td {
        border-bottom: 1px solid #ddd;
        padding: 12px 15px;
        font-weight: bold;
        vertical-align: middle;
    }

    .table-retro tbody tr:hover { background-color: #fffde7; }

    /* Button row */
    .btn-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 28px;
    }

    /* Divider */
    .retro-divider {
        width: 100%;
        max-width: 700px;
        border: none;
        border-top: 3px dashed #000;
        margin: 0 0 30px;
    }

    /* Delete card */
    .delete-card {
        background: #fff5f5;
        border: 4px solid #ff4d4d;
        padding: 20px 35px;
        box-shadow: 8px 8px 0px 0px #ff4d4d;
        width: 100%;
        max-width: 700px;
        margin-bottom: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .delete-card-label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        color: #000;
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
    <h1 class="page-title">Edit Order #{{ $order->id }}</h1>

    @if(session('success'))
        <div class="error-retro" style="background:#00ff41; color:#000;">
            [SYSTEM_LOG]: {{ session('success') }}
        </div>
    @endif

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

    <!-- Update Form -->
    <div class="form-card">
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Customer (read-only) -->
            <div class="form-group-retro">
                <label>Customer</label>
                <input type="text" class="form-control-retro"
                       value="{{ $order->user->first_name }} {{ $order->user->last_name }}" disabled>
            </div>

            <!-- Status -->
            <div class="form-group-retro">
                <label for="status">Order Status</label>
                <select name="status" id="status" class="form-control-retro @error('status') is-invalid @enderror">
                    <option value="Pending"    {{ $order->status == 'Pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Shipped"    {{ $order->status == 'Shipped'    ? 'selected' : '' }}>Shipped</option>
                    <option value="Completed"  {{ $order->status == 'Completed'  ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled"  {{ $order->status == 'Cancelled'  ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Address -->
            <div class="form-group-retro">
                <label for="address">Shipping Address</label>
                <input type="text" name="address" id="address"
                       class="form-control-retro @error('address') is-invalid @enderror"
                       value="{{ old('address', $order->user->address) }}">
                @error('address') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Remarks -->
            <div class="form-group-retro">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" id="remarks"
                          class="form-control-retro @error('remarks') is-invalid @enderror">{{ old('remarks', $order->remarks) }}</textarea>
                @error('remarks') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <!-- Order Items -->
            <div class="section-heading">Order Items</div>
            <table class="table-retro">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->product->brand }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="btn-row">
                <a href="{{ route('admin.orders.index') }}" class="btn-retro btn-secondary-retro">Back</a>
                <button type="submit" class="btn-retro btn-primary-retro">Save Changes</button>
            </div>
        </form>
    </div>

    <hr class="retro-divider">

    <!-- Delete Zone -->
    <div class="delete-card">
        <span class="delete-card-label">⚠ Danger Zone — This action cannot be undone.</span>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-retro btn-danger-retro"
                    onclick="return confirm('Are you sure you want to delete this order?')">
                Delete Order
            </button>
        </form>
    </div>
</div>
@endsection