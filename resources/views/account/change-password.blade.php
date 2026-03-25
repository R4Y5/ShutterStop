@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist Layout Base */
    body {
        background-color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        background-image: linear-gradient(#d0d0d0 1px, transparent 1px), linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .retro-container {
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.8rem;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 20px;
        letter-spacing: -1px;
        color: #000000;
        display: inline-block;
        padding: 5px 20px;
        width: 100%;
        max-width: 500px;
    }

    /* Alert Styling */
    .alert-retro-success {
        background-color: #00ff41;
        color: #000;
        border: 3px solid #000;
        padding: 15px;
        font-weight: bold;
        margin-bottom: 25px;
        box-shadow: 6px 6px 0px 0px #000;
        text-transform: uppercase;
        width: 100%;
        max-width: 500px;
    }

    .alert-retro-danger {
        background-color: #ff4d4d;
        color: #fff;
        border: 3px solid #000;
        padding: 15px;
        font-weight: bold;
        margin-bottom: 25px;
        box-shadow: 6px 6px 0px 0px #000;
        text-transform: uppercase;
        width: 100%;
        max-width: 500px;
    }

    /* Form Card */
    .form-card {
        background: #fff;
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        width: 100%;
        max-width: 500px;
        margin-bottom: 50px;
        overflow: hidden;
    }

    .form-card-header {
        background: #000;
        color: #fff;
        padding: 14px 20px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
    }

    .form-card-body {
        padding: 30px;
    }

    /* Form Groups */
    .form-group-retro {
        margin-bottom: 24px;
    }

    .form-group-retro label {
        display: block;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin-bottom: 8px;
        color: #000;
    }

    .form-control-retro {
        width: 100%;
        border: 3px solid #000;
        border-radius: 0;
        padding: 10px 14px;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 0.95rem;
        background: #fff;
        box-shadow: 4px 4px 0px #000;
        transition: all 0.1s;
        box-sizing: border-box;
    }

    .form-control-retro:focus {
        outline: none;
        box-shadow: 0px 0px 0px #000;
        transform: translate(2px, 2px);
        background: #fffde7;
    }

    /* Checkbox */
    .checkbox-retro {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .checkbox-retro input[type="checkbox"] {
        width: 18px;
        height: 18px;
        border: 2px solid #000;
        border-radius: 0;
        cursor: pointer;
        accent-color: #000;
        flex-shrink: 0;
    }

    .checkbox-retro label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin: 0;
        cursor: pointer;
    }

    /* Button */
    .btn-retro {
        border: 3px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 12px 20px;
        transition: all 0.1s;
        box-shadow: 5px 5px 0px 0px #000;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        color: #000;
        font-family: 'Courier New', Courier, monospace;
        width: 100%;
        text-align: center;
    }
    .btn-retro:hover { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #000; color: #000; }
    .btn-primary-retro { background-color: #ffff00; }
</style>

<div class="container-fluid retro-container">
    <h1 class="page-title">Security</h1>

    @if(session('success'))
        <div class="alert-retro-success">[SYSTEM_LOG]: {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-retro-danger">
            [ERROR]:
            <ul class="mb-0" style="margin: 8px 0 0 16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <div class="form-card-header">{{ __('Change Password') }}</div>
        <div class="form-card-body">
            <form action="{{ route('account.password.update') }}" method="POST">
                @csrf

                <div class="form-group-retro">
                    <label>{{ __('Current Password') }}</label>
                    <input type="password" name="current_password"
                           class="form-control-retro password-field"
                           required placeholder="••••••••">
                </div>

                <div class="form-group-retro">
                    <label>{{ __('New Password') }}</label>
                    <input type="password" name="new_password"
                           class="form-control-retro password-field"
                           required placeholder="••••••••">
                </div>

                <div class="form-group-retro">
                    <label>{{ __('Confirm New Password') }}</label>
                    <input type="password" name="new_password_confirmation"
                           class="form-control-retro password-field"
                           required placeholder="••••••••">
                </div>

                <div class="form-group-retro">
                    <div class="checkbox-retro">
                        <input type="checkbox" id="togglePasswords">
                        <label for="togglePasswords">Show Passwords</label>
                    </div>
                </div>

                <div class="form-group-retro" style="margin-bottom: 0; margin-top: 32px;">
                    <button type="submit" class="btn-retro btn-primary-retro">
                        {{ __('Update Password') }}
                    </button>
                </div>
            </form>
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