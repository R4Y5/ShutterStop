@extends('layouts.app')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
<div class="container">
    <h1>Add New Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Brand</label>
            <select name="brand" class="form-select" required>
                <option value="">-- Select Brand --</option>
                <option value="Sony"  {{ old('brand', $product->brand ?? '') == 'Sony' ? 'selected' : '' }}>Sony</option>
                <option value="Canon" {{ old('brand', $product->brand ?? '') == 'Canon' ? 'selected' : '' }}>Canon</option>
                <option value="Nikon" {{ old('brand', $product->brand ?? '') == 'Nikon' ? 'selected' : '' }}>Nikon</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ old('stock', 0) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Additional Photos</label>
            <input type="file" name="photos[]" class="form-control" accept="image/*" multiple>
        </div>

        <button type="submit" class="btn btn-success">Save Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
