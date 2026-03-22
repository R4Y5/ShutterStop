<a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
    <i class="bi bi-pencil-square"></i> Edit
</a>

<form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('Are you sure you want to delete this product?')">
        <i class="bi bi-trash"></i> Delete
    </button>
</form>
