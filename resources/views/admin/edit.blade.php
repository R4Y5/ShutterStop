@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist / Retro UI Overrides */
    body {
        background-color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        background-image:
            linear-gradient(#d0d0d0 1px, transparent 1px),
            linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .retro-container {
        padding: 40px 0;
    }

    .form-wrapper {
        max-width: 650px;
        margin: 0 auto;
    }

    /* Card Styling */
    .card-retro {
        border: 4px solid #000 !important;
        border-radius: 0 !important;
        box-shadow: 12px 12px 0px 0px #000;
        background-color: #fff;
    }

    .card-header-retro {
        background-color: #000 !important;
        color: #fff !important;
        border-radius: 0 !important;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 15px;
    }

    .section-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    /* Form Elements */
    label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-retro {
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        padding: 12px;
        background-color: #fff;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
    }

    .form-control-retro:focus {
        box-shadow: 6px 6px 0px 0px #000;
        border-color: #000;
        outline: none;
    }

    /* Buttons */
    .btn-retro-submit {
        background-color: #00ff41 !important; /* Matrix Green */
        color: #000 !important;
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        font-weight: 900;
        text-transform: uppercase;
        transition: all 0.1s;
        box-shadow: 6px 6px 0px 0px #000;
        padding: 15px;
        width: 100%;
        cursor: pointer;
    }

    .btn-retro-submit:hover {
        background-color: #000 !important;
        color: #00ff41 !important;
        box-shadow: none;
        transform: translate(3px, 3px);
    }

    /* Alerts and Errors */
    .alert-retro {
        background-color: #00ff41;
        color: #000;
        border: 3px solid #000;
        font-weight: bold;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 6px 6px 0px 0px #000;
        text-transform: uppercase;
    }

    .invalid-feedback-retro {
        color: #ff0000;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.75rem;
        margin-top: 5px;
        display: block;
    }

    .profile-img-preview {
        border: 3px solid #000;
        box-shadow: 5px 5px 0px 0px #000;
        margin-bottom: 15px;
    }
</style>

<div class="container retro-container">
    <div class="form-wrapper">
        <h1 class="section-title">Account Settings</h1>

        @if(session('success'))
            <div class="alert-retro">
                [SYSTEM]: {{ session('success') }}
            </div>
        @endif

        <div class="card card-retro">
            <div class="card-header-retro">Identity Registry</div>

            <div class="card-body p-4">
                <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name"
                                   placeholder="ENTER FIRST NAME"
                                   class="form-control-retro w-100 @error('first_name') is-invalid @enderror">
                            @error('first_name')
                                <div class="invalid-feedback-retro">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name"
                                   placeholder="ENTER LAST NAME"
                                   class="form-control-retro w-100 @error('last_name') is-invalid @enderror">
                            @error('last_name')
                                <div class="invalid-feedback-retro">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email"
                               placeholder="USER@DOMAIN.COM"
                               class="form-control-retro w-100 @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback-retro">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" name="contact_no" id="contact_no"
                               placeholder="+00 000 000 000"
                               class="form-control-retro w-100 @error('contact_no') is-invalid @enderror">
                        @error('contact_no')
                            <div class="invalid-feedback-retro">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" rows="3"
                                  placeholder="ENTER FULL ADDRESS DETAILS..."
                                  class="form-control-retro w-100 @error('address') is-invalid @enderror"></textarea>
                        @error('address')
                            <div class="invalid-feedback-retro">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="photo">Profile Photo</label>
                        @if($user->photo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" width="120" class="profile-img-preview">
                            </div>
                        @endif
                        <input type="file" name="photo" id="photo" class="form-control-retro w-100 @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback-retro">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-retro-submit">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
