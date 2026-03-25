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

    .retro-container { padding: 60px 20px; }
    .form-wrapper { max-width: 800px; margin: 0 auto; }

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 3rem;
        text-transform: uppercase;
        margin-bottom: 30px;
        letter-spacing: -1px;
        color: #000000;
        display: inline-block;
        padding: 5px 20px;
    }

    /* Card Styling */
    .card-retro {
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        background-color: #fff;
        padding: 40px;
    }

    /* Form Elements */
    label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.9rem;
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
        width: 100%;
        margin-bottom: 20px;
        transition: all 0.1s;
    }

    .form-control-retro:focus {
        box-shadow: 6px 6px 0px 0px #000;
        outline: none;
        background-color: #f0f0f0;
    }

    /* Button Grouping */
    .btn-group-retro {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .btn-retro {
        flex: 1;
        border: 3px solid #000;
        padding: 15px;
        font-weight: 900;
        text-transform: uppercase;
        text-decoration: none;
        text-align: center;
        box-shadow: 8px 8px 0px 0px #000;
        transition: all 0.1s;
        cursor: pointer;
        display: inline-block;
        color: #000;
    }

    .btn-retro:hover {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px 0px #000;
    }

    .btn-save { background-color: #00ff41; } /* Neon Green */
    .btn-cancel { background-color: #fff; }
</style>

<div class="container retro-container">
    <div class="form-wrapper">
        <h1 class="page-title">Create New User</h1>

        <div class="card-retro">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control-retro" required placeholder="JON">
                    </div>

                    <div class="col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control-retro" required placeholder="DOE">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control-retro" required placeholder="USER@SYSTEM.COM">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control-retro" required placeholder="********">
                    </div>

                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control-retro" required placeholder="********">
                    </div>
                </div>

                <div class="mb-4">
                    <label>System Role</label>
                    <select name="role" class="form-control-retro">
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="btn-group-retro">
                    <button type="submit" class="btn-retro btn-save">Create User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn-retro btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
