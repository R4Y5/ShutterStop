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

    .retro-container { padding: 60px 20px; }
    .form-wrapper { max-width: 800px; margin: 0 auto; }

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        text-transform: uppercase;
        margin-bottom: 30px;
        letter-spacing: -1px;
        background: #000;
        color: #fff;
        display: inline-block;
        padding: 5px 20px;
    }

    /* Error Alert Styling */
    .alert-danger-retro {
        border: 4px solid #000;
        background-color: #ff3e3e;
        color: #fff;
        padding: 20px;
        box-shadow: 10px 10px 0px 0px #000;
        margin-bottom: 30px;
    }
    .alert-danger-retro ul { margin: 0; padding-left: 20px; font-weight: bold; }

    /* Card Styling */
    .card-retro {
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        background-color: #fff;
        padding: 40px;
    }

    /* Form Elements */
    label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-retro {
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        padding: 12px;
        background-color: #fff;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        width: 100%;
        margin-bottom: 20px;
        transition: transform 0.1s;
    }

    .form-control-retro:focus {
        box-shadow: 6px 6px 0px 0px #000;
        outline: none;
        transform: translate(-2px, -2px);
    }

    /* Button Grouping */
    .btn-group-retro {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .btn-retro {
        flex: 1;
        border: 3px solid #000;
        padding: 15px;
        font-weight: 900;
        text-transform: uppercase;
        text-decoration: none;
        text-align: center;
        box-shadow: 8px 8px 0px 0px #000;
        transition: all 0.1s;
        cursor: pointer;
        display: inline-block;
        color: #000;
    }

    .btn-retro:hover {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px 0px #000;
    }

    .btn-save { background-color: #00ff41; }
    .btn-cancel { background-color: #fff; }
</style>

<div class="container retro-container">
    <div class="form-wrapper">
        <h1 class="page-title">Add New Product</h1>

        @if ($errors->any())
            <div class="alert-danger-retro">
                <p><strong>[SYSTEM_ERROR] VALIDATION_FAILED:</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-retro">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label>Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control-retro" required placeholder="ENTER_NAME">
                    </div>

                    <div class="col-md-6">
                        <label>Brand</label>
                        <select name="brand" class="form-control-retro" required>
                            <option value="">-- SELECT BRAND --</option>
                            <option value="Sony"  {{ old('brand') == 'Sony' ? 'selected' : '' }}>Sony</option>
                            <option value="Canon" {{ old('brand') == 'Canon' ? 'selected' : '' }}>Canon</option>
                            <option value="Nikon" {{ old('brand') == 'Nikon' ? 'selected' : '' }}>Nikon</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control-retro" rows="4" placeholder="DESCRIBE_PRODUCT_SPECS...">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label>Price (PHP)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-control-retro" required placeholder="0.00">
                    </div>

                    <div class="col-md-4">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" class="form-control-retro" required>
                    </div>

                    <div class="col-md-4">
                        <label>Category</label>
                        <select name="category_id" class="form-control-retro">
                            <option value="">-- SELECT CATEGORY --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label>Additional Photos (Multiple)</label>
                    <input type="file" name="photos[]" class="form-control-retro" accept="image/*" multiple style="background: #eee;">
                </div>

                <div class="btn-group-retro">
                    <button type="submit" class="btn-retro btn-save">Save Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-retro btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
