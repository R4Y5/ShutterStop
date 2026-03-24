{{-- User Actions Partial --}}
<style>
    .btn-action-retro {
        border: 2px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.7rem;
        padding: 5px 10px;
        transition: all 0.1s;
        box-shadow: 3px 3px 0px 0px #000;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        color: #000;
        margin: 2px;
    }

    .btn-action-retro:hover {
        transform: translate(1px, 1px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    /* Action specific colors */
    .btn-edit-user { background-color: #ffff00; }    /* Neon Yellow */
    .btn-delete-user { background-color: #ff3e3e; color: #fff !important; } /* Red */
    .btn-status-active { background-color: #00ff41; } /* Neon Green (to deactivate) */
    .btn-status-inactive { background-color: #fff; }  /* White (to activate) */

    .action-flex-container {
        display: flex;
        flex-wrap: wrap;
        gap: 2px;
    }
</style>

<div class="action-flex-container">
    {{-- Edit Button --}}
    <a href="{{ route('admin.users.edit', $user) }}" class="btn-action-retro btn-edit-user">
        <i class="bi bi-pencil-square"></i> Edit
    </a>

    {{-- Toggle Status Button --}}
    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display:inline;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn-action-retro {{ $user->is_active ? 'btn-status-active' : 'btn-status-inactive' }}">
            <i class="bi {{ $user->is_active ? 'bi-person-x' : 'bi-person-check' }}"></i>
            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
        </button>
    </form>

    {{-- Delete Button --}}
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-action-retro btn-delete-user"
            onclick="return confirm('Are you sure you want to delete this user?')">
            <i class="bi bi-trash"></i> Delete
        </button>
    </form>
</div>
