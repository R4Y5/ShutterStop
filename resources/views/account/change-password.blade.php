@extends('layouts.app')

@section('content')
<style>
    /* Constraint for the form width */
    .form-wrapper {
        max-width: 500px;
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
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #000;
        border-color: #000;
    }

    .alert-retro-success {
        background-color: #000;
        color: #fff;
        border-radius: 0;
        border: none;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .alert-retro-danger {
        background-color: #ff0000;
        color: #fff;
        border-radius: 0;
        border: 3px solid #000;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        box-shadow: 4px 4px 0px 0px #000;
    }
</style>

<div class="container">
    <div class="form-wrapper">
        <div class="hero-text">
            <h1>Security.</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-retro-success text-center">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-retro-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">{{ __('Change Password') }}</div>

            <div class="card-body">
                <form action="{{ route('account.password.update') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label>{{ __('Current Password') }}</label>
                        <input type="password" name="current_password" class="form-control password-field" required placeholder="••••••••">
                    </div>

                    <div class="mb-4">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="new_password" class="form-control password-field" required placeholder="••••••••">
                    </div>

                    <div class="mb-4">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="new_password_confirmation" class="form-control password-field" required placeholder="••••••••">
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="togglePasswords">
                            <label class="form-check-label" for="togglePasswords">
                                Show Passwords
                            </label>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-retro">
                            {{ __('Update Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePasswords').addEventListener('change', function() {
        const fields = document.querySelectorAll('.password-field');
        fields.forEach(field => {
            field.type = this.checked ? 'text' : 'password';
        });
    });
</script>
@endsection
