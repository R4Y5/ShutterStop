@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Users</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create New User</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Current Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" width="50" height="50" class="rounded-circle">
                        @else
                            <span class="text-muted">No photo</span>
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->implode(', ') ?: 'None' }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
