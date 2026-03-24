@extends('layouts.app')

@section('content')
<style>
    /* Retro UI Overrides */
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

    /* Constraint for the form width */
    .form-wrapper {
        max-width: 500px;
        margin: 0 auto;
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
        padding: 10px;
        background-color: #fff;
    }

    .form-control:focus {
        box-shadow: 4px 4px 0px 0px #000;
        border-color: #000;
        outline: none;
    }

    .btn-retro {
        background-color: #fff !important;
        color: #000 !important;
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.2s;
        box-shadow: 4px 4px 0px 0px #000;
        padding: 10px 20px;
        width: 100%;
    }

    .btn-retro:hover {
        background-color: #000 !important;
        color: #fff !important;
        box-shadow: none;
        transform: translate(2px, 2px);
    }

    label {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.85rem;
        margin-bottom: 5px;
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

    .form-check-input {
        border: 2px solid #000;
        border-radius: 0;
    }

    .form-check-input:checked {
        background-color: #000;
        border-color: #000;
    }

    .invalid-feedback {
        font-weight: bold;
        color: #ff0000;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
</style>

<div class="container retro-container">
    <div class="form-wrapper">
        <div class="hero-text">
            <h1>Ready. Set. Register.</h1>
        </div>

        <div class="card">
            <div class="card-header">{{ __('Register') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="first_name">{{ __('First Name') }}</label>
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                            name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name" autofocus placeholder="First Name">
                        @error('first_name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="last_name">{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                            name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" placeholder="Last Name">
                        @error('last_name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@mail.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_no">{{ __('Contact Number') }}</label>
                        <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror"
                            name="contact_no" value="{{ old('contact_no') }}" required autocomplete="tel" placeholder="09XXXXXXXXX">
                        @error('contact_no')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address">{{ __('Address') }}</label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                            name="address" value="{{ old('address') }}" required autocomplete="street-address" placeholder="Street, City, Province">
                        @error('address')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="mb-4">
                        <label for="photo">{{ __('Profile Photo') }}</label>
                        <input id="photo" type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the Terms & Conditions
                            </label>
                            @error('terms')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-retro">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
