@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Account</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Email (read-only) -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" value="{{ $user->email }}" class="form-control" readonly>
        </div>

        <!-- First Name -->
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name"
                   value="{{ old('first_name', $user->first_name) }}"
                   class="form-control @error('first_name') is-invalid @enderror">
            @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name"
                   value="{{ old('last_name', $user->last_name) }}"
                   class="form-control @error('last_name') is-invalid @enderror">
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contact No. -->
        <div class="mb-3">
            <label>Contact No.</label>
            <input type="text" name="contact_no" value="{{ $user->contact_no }}" class="form-control">
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $user->address }}</textarea>
        </div>

        <!-- Profile Image -->
        <div class="mb-3">
            <label>Profile Image</label>
            <div class="mb-2">
                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.png') }}" 
                     alt="Profile Photo" width="100" class="rounded">
            </div>
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
</div>
@endsection
