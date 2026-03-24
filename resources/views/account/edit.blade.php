@extends('layouts.app')

@section('content')
<style>
    /* Constraint for the form width */
    .form-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 0;
    }

    .card {
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        box-shadow: 8px 8px 0px 0px #000;
        background-color: #fff;
    }

    .card-header {
        background-color: #000 !important;
        color: #fff !important;
        border-radius: 0 !important;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .form-control {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        padding: 12px;
        background-color: #fff;
    }

    .form-control:focus {
        box-shadow: 4px 4px 0px 0px #000;
        border-color: #000;
        outline: none;
    }

    .form-control[readonly] {
        background-color: #f0f0f0;
        cursor: not-allowed;
    }

    /* Buttons */
    .btn-retro-save {
        background-color: #000 !important;
        color: #fff !important;
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.2s;
        box-shadow: 4px 4px 0px 0px #d0d0d0;
        padding: 10px 25px;
    }

    .btn-retro-save:hover {
        background-color: #333 !important;
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px 0px #000;
    }

    .btn-retro-cancel {
        background-color: #fff !important;
        color: #000 !important;
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.2s;
        box-shadow: 4px 4px 0px 0px #000;
        padding: 10px 25px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-retro-cancel:hover {
        background-color: #f0f0f0 !important;
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px 0px #000;
    }

    label {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: block;
    }

    .hero-text h1 {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        line-height: 1.1;
        margin-bottom: 20px;
        text-align: center;
    }

    .profile-preview {
        border: 3px solid #000;
        box-shadow: 4px 4px 0px 0px #000;
        margin-bottom: 15px;
        border-radius: 0 !important;
    }
</style>

<div class="container">
    <div class="form-wrapper">
        <div class="hero-text">
            <h1>Settings.</h1>
        </div>

        <div class="card">
            <div class="card-header">{{ __('Edit Account') }}</div>

            <div class="card-body p-4">
                <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name" value="" class="form-control" placeholder="Enter first name">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value="" class="form-control" placeholder="Enter last name">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label>Contact No.</label>
                        <input type="text" name="contact_no" value="" class="form-control" placeholder="09xxxxxxxxx">
                    </div>

                    <div class="mb-4">
                        <label>Home Address</label>
                        <textarea name="address" rows="3" class="form-control" placeholder="Street, City, Province"></textarea>
                    </div>

                    <div class="mb-4">
                        <label>Profile Image</label>
                        @if(auth()->user()->photo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile Photo" width="120" class="profile-preview">
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('home') }}" class="btn-retro-cancel">Cancel</a>
                        <button type="submit" class="btn-retro-save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
