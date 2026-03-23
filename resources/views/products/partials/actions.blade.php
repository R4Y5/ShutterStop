{{-- resources/views/products/partials/actions.blade.php --}}
@if(!$product->deleted_at)
    {{-- Normal actions for active products --}}
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>

    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger"
            onclick="return confirm('Are you sure you want to delete this product?')">
            Delete
        </button>
    </form>
@else
    {{-- Actions for soft-deleted products --}}
    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-sm btn-warning"
            onclick="return confirm('Restore this product?')">
            Restore
        </button>
    </form>

    <form action="{{ route('admin.products.forceDestroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-dark"
            onclick="return confirm('Permanently delete this product and its images?')">
            Force Delete
        </button>
    </form>
@endif
