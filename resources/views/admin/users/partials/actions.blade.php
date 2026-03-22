<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
    <i class="bi bi-pencil-square"></i> Edit
</a>

<form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('Are you sure you want to delete this user?')">
        <i class="bi bi-trash"></i> Delete
    </button>
</form>

<form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" style="display:inline;">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-info btn-sm">
        @if($user->status === 'Active')
            <i class="bi bi-x-circle"></i> Deactivate
        @else
            <i class="bi bi-check-circle"></i> Activate
        @endif
    </button>
</form>
