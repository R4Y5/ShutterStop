@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Admin</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>
    <h1>Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" readonly>
        </div>

        <!-- First Name -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name"
                value="{{ old('first_name', $user->first_name) }}"
                class="form-control">
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name"
                value="{{ old('last_name', $user->last_name) }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Contact No.</label>
            <input type="text" name="contact_no" value="{{ old('contact_no', $user->contact_no) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
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
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Back to User List</a>
    </form>
</div>
@endsection
