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

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $user->email) }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contact No -->
        <div class="mb-3">
            <label for="contact_no" class="form-label">Contact No</label>
            <input type="text" name="contact_no" id="contact_no"
                   value="{{ old('contact_no', $user->contact_no) }}"
                   class="form-control @error('contact_no') is-invalid @enderror">
            @error('contact_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address"
                      class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Profile Image -->
        <div class="mb-3">
            <label for="photo" class="form-label">Profile Image</label>
            @if($user->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" width="100" class="rounded">
                </div>
            @endif
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
