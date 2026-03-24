@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Account</h1>

    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Email (readonly) -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" readonly>
        </div>

        <!-- First Name -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="" class="form-control">
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="" class="form-control">
        </div>

        <!-- Contact No -->
        <div class="mb-3">
            <label>Contact No.</label>
            <input type="text" name="contact_no" value="" class="form-control">
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <!-- Profile Image -->
        <div class="mb-3">
            <label>Profile Image</label>
            @if(auth()->user()->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile Photo" width="100" class="rounded">
                </div>
            @endif
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
