<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>

<form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('Are you sure you want to delete this user?')">
        Delete
    </button>
</form>

<form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" style="display:inline;">
    @csrf @method('PATCH')
    <button type="submit" class="btn btn-info btn-sm">
        {{ $user->status === 'Active' ? 'Deactivate' : 'Activate' }}
    </button>
</form>
