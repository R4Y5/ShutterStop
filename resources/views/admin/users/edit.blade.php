@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="customer" {{ $user->hasRole('customer') ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
