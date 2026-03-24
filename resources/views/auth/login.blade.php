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

    .btn-link-retro {
        color: #000;
        text-decoration: underline;
        font-weight: bold;
        font-size: 0.8rem;
        text-transform: uppercase;
        display: block;
        text-align: center;
        margin-top: 15px;
    }

    .btn-link-retro:hover {
        color: #444;
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
            <h1>Ready. Set. Login.</h1>
        </div>

        <div class="card">
            <div class="card-header">{{ __('Login') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-retro">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link-retro" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
