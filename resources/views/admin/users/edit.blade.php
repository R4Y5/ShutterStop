@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contact No.</label>
            <input type="text" name="contact_no" value="{{ $user->contact_no }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $user->address }}</textarea>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="customer" {{ $user->hasRole('customer') ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Profile Image</label>
            @if($user->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" width="100" class="rounded">
                </div>
            @endif
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
