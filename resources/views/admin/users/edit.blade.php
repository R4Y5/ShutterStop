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

        <!-- First Name -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name"
                value=""
                class="form-control">
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name"
                value=""
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Contact No.</label>
            <input type="text" name="contact_no" value="" class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
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
