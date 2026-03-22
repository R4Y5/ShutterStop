{{-- resources/views/products/partials/actions.blade.php --}}
@if(!$product->deleted_at)
    {{-- Normal actions for active products --}}
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
@else
    {{-- Restore button for soft-deleted products --}}
    <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-sm btn-warning">Restore</button>
    </form>
@endif
