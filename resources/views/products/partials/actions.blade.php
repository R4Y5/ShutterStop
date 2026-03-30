{{-- resources/views/products/partials/actions.blade.php --}}
<style>
    .btn-action-retro {
        border: 2px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.7rem;
        padding: 4px 10px;
        transition: all 0.1s;
        box-shadow: 3px 3px 0px 0px #000;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        color: #000;
        margin: 2px;
    }

    .btn-action-retro:hover {
        transform: translate(1px, 1px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    .btn-edit-retro { background-color: #ffff00; }    /* Neon Yellow */
    .btn-delete-retro { background-color: #ff3e3e; color: #fff !important; } /* Red */
    .btn-restore-retro { background-color: #00ff41; } /* Neon Green */
    .btn-force-retro { background-color: #000; color: #fff !important; }    /* Black */
</style>

<div class="d-flex flex-wrap">
    @if(!$product->deleted_at)
        {{-- Normal actions for active products --}}
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action-retro btn-edit-retro">
            Edit
        </a>

        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-action-retro btn-delete-retro"
                onclick="return confirm('Are you sure you want to delete this product?')">
                Delete
            </button>
        </form>
    @else
        {{-- Actions for soft-deleted products --}}
        <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-action-retro btn-restore-retro"
                onclick="return confirm('Restore this product?')">
                Restore
            </a>
        </form>
    @endif
</div>
