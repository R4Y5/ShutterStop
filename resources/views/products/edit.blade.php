@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <!-- Product fields -->
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Brand</label>
            <select name="brand" class="form-select" required>
                <option value="">-- Select Brand --</option>
                <option value="Sony"  {{ old('brand', $product->brand) == 'Sony' ? 'selected' : '' }}>Sony</option>
                <option value="Canon" {{ old('brand', $product->brand) == 'Canon' ? 'selected' : '' }}>Canon</option>
                <option value="Nikon" {{ old('brand', $product->brand) == 'Nikon' ? 'selected' : '' }}>Nikon</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" required>
        </div>

        <!-- Photos -->
        <div class="mb-3">
            <label>Photos (select main)</label>
            <div id="photo-grid" class="d-flex flex-wrap">
                @foreach($product->photos as $photo)
                    <div class="position-relative m-2 photo-item" data-id="{{ $photo->id }}">
                        <img src="{{ asset('storage/' . $photo->path) }}" width="100" class="rounded border">
                        <!-- Delete button -->
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                            onclick="deletePhoto({{ $photo->id }})">X</button>
                        <!-- Main photo radio -->
                        <div class="form-check position-absolute bottom-0 start-0 bg-light px-1 rounded">
                            <input class="form-check-input" type="radio" name="main_photo_id" value="{{ $photo->id }}"
                                {{ $product->photo == $photo->path ? 'checked' : '' }}>
                            <label class="form-check-label small">Main</label>
                        </div>
                    </div>
                @endforeach
            </div>

            <input type="file" name="photos[]" class="form-control mt-2" accept="image/*" multiple onchange="previewImages(event)">
        </div>

        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

{{-- JS for deleting and previewing photos --}}
<script>
function deletePhoto(photoId) {
    if(confirm('Delete this photo?')) {
        fetch("{{ url('/admin/products/photos') }}/" + photoId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.querySelector('.photo-item[data-id="' + photoId + '"]').remove();
            } else {
                alert('Failed to delete photo.');
            }
        })
        .catch(() => alert('Error deleting photo.'));
    }
}

function previewImages(event) {
    const grid = document.getElementById('photo-grid');
    Array.from(event.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('position-relative', 'm-2', 'photo-item');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('rounded', 'border');
            img.style.width = '100px';

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute', 'top-0', 'end-0');
            btn.textContent = 'X';
            btn.onclick = () => wrapper.remove(); // remove preview before upload

            // Main photo radio for new uploads
            const radioWrapper = document.createElement('div');
            radioWrapper.classList.add('form-check', 'position-absolute', 'bottom-0', 'start-0', 'bg-light', 'px-1', 'rounded');
            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'main_photo_id';
            radio.classList.add('form-check-input');
            radio.value = 'new'; // placeholder, handled in controller if needed
            const label = document.createElement('label');
            label.classList.add('form-check-label', 'small');
            label.textContent = 'Main';
            radioWrapper.appendChild(radio);
            radioWrapper.appendChild(label);

            wrapper.appendChild(img);
            wrapper.appendChild(btn);
            wrapper.appendChild(radioWrapper);
            grid.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
