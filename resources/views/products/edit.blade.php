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
    .form-wrapper { max-width: 900px; margin: 0 auto; }

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        text-transform: uppercase;
        margin-bottom: 30px;
        letter-spacing: -1px;
        background: #ffff00;
        color: #000;
        display: inline-block;
        padding: 5px 20px;
        border: 4px solid #000;
        box-shadow: 8px 8px 0px 0px #000;
    }

    .card-retro {
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        background-color: #fff;
        padding: 40px;
    }

    label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-retro {
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        padding: 12px;
        font-weight: bold;
        width: 100%;
        margin-bottom: 20px;
        background: #fff;
    }

    .form-control-retro:focus {
        box-shadow: 5px 5px 0px 0px #000;
        outline: none;
    }

    .photo-item {
        border: 3px solid #000;
        background: #eee;
        box-shadow: 4px 4px 0px 0px #000;
        padding: 5px;
        margin: 10px;
    }

    .btn-retro {
        border: 3px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        padding: 15px 30px;
        box-shadow: 6px 6px 0px 0px #000;
        transition: 0.1s;
        cursor: pointer;
        display: inline-block;
        color: #000;
        text-decoration: none;
    }

    .btn-retro:hover { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #000; }
    .btn-success-retro { background-color: #00ff41; }
    .btn-secondary-retro { background-color: #fff; }
</style>

<div class="container retro-container">
    <div class="form-wrapper">
        <h1 class="page-title">Edit Product: [ID_{{ $product->id }}]</h1>

        <div class="card-retro">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <label>Product Name</label>
                        {{-- Changed to empty string default --}}
                        <input type="text" name="name" value="{{ old('name', '') }}" class="form-control-retro" required placeholder="ENTER NEW NAME">
                    </div>
                    <div class="col-md-4">
                        <label>Brand</label>
                        <select name="brand" class="form-control-retro" required>
                            <option value="">-- SELECT BRAND --</option>
                            <option value="Sony"  {{ old('brand') == 'Sony' ? 'selected' : '' }}>Sony</option>
                            <option value="Canon" {{ old('brand') == 'Canon' ? 'selected' : '' }}>Canon</option>
                            <option value="Nikon" {{ old('brand') == 'Nikon' ? 'selected' : '' }}>Nikon</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-3">
                        <label>Price (PHP)</label>
                        {{-- Changed to empty string default --}}
                        <input type="number" step="0.01" name="price" value="{{ old('price', '') }}" class="form-control-retro" required placeholder="0.00">
                    </div>
                    <div class="col-md-3">
                        <label>Stock</label>
                        {{-- Changed to empty string default --}}
                        <input type="number" name="stock" value="{{ old('stock', '') }}" class="form-control-retro" required placeholder="QTY">
                    </div>
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    {{-- Changed to empty string default --}}
                    <textarea name="description" class="form-control-retro" rows="3" placeholder="ENTER NEW DESCRIPTION">{{ old('description', '') }}</textarea>
                </div>

                <div class="mb-4 p-3" style="border: 2px dashed #000; background: #f9f9f9;">
                    <label class="mb-3">Current Asset Gallery (Select Main)</label>
                    <div id="photo-grid" class="d-flex flex-wrap">
                        @foreach($product->photos as $photo)
                            <div class="position-relative photo-item" data-id="{{ $photo->id }}">
                                <img src="{{ asset('storage/' . $photo->path) }}" style="width:100px; height:100px; object-fit:cover;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="deletePhoto({{ $photo->id }})">×</button>
                                <div class="bg-white border-top border-dark p-1 d-flex align-items-center">
                                    <input type="radio" name="main_photo_id" value="{{ $photo->id }}" {{ $product->photo == $photo->path ? 'checked' : '' }}>
                                    <span style="font-size:0.7rem; font-weight:900; margin-left:5px;">MAIN</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <label>Upload New Assets</label>
                        <input type="file" name="photos[]" class="form-control-retro" accept="image/*" multiple onchange="previewImages(event)">
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn-retro btn-success-retro">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-retro btn-secondary-retro">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// JS remains unchanged as it handles functionality
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
            } else { alert('Failed to delete photo.'); }
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
            wrapper.classList.add('position-relative', 'photo-item');
            wrapper.innerHTML = `
                <img src="${e.target.result}" style="width:100px; height:100px; object-fit:cover;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="this.parentElement.remove()">×</button>
                <div class="bg-white border-top border-dark p-1 d-flex align-items-center">
                    <input type="radio" name="main_photo_id" value="new">
                    <span style="font-size:0.7rem; font-weight:900; margin-left:5px;">NEW</span>
                </div>
            `;
            grid.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
