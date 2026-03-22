@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Brand</label>
            <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Additional Photos</label>
            @if($product->photos->count())
                <div class="d-flex flex-wrap">
                    @foreach($product->photos as $photo)
                        <div class="position-relative m-2">
                            <img src="{{ asset('storage/' . $photo->path) }}" width="80" class="rounded">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                onclick="deletePhoto({{ $photo->id }})">X</button>
                        </div>
                    @endforeach
                </div>
            @else
                <span class="text-muted">No additional photos</span>
            @endif

            <input type="file" name="photos[]" class="form-control mt-2" accept="image/*" multiple>
        </div>

        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

{{-- JS for deleting photos --}}
<script>
function deletePhoto(photoId) {
    if(confirm('Delete this photo?')) {
        fetch("{{ url('/products/photos') }}/" + photoId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection
