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
    .form-wrapper { max-width: 850px; margin: 0 auto; }

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
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-retro {
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        padding: 12px;
        font-weight: bold;
        width: 100%;
        margin-bottom: 20px;
        background: #fff;
    }

    .form-control-retro:focus {
        box-shadow: 5px 5px 0px 0px #000;
        outline: none;
    }

    .form-control-readonly {
        background-color: #e9e9e9 !important;
        cursor: not-allowed;
        border-style: dashed !important;
    }

    /* Profile Image Asset */
    .profile-asset-box {
        border: 3px solid #000;
        background: #f0f0f0;
        display: inline-block;
        padding: 10px;
        box-shadow: 5px 5px 0px 0px #000;
        margin-bottom: 15px;
    }

    /* Action bar */
    .action-card {
        background: #fff;
        border: 4px solid #000;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 10px 10px 0px 0px #000;
    }

    /* Buttons */
    .btn-retro {
        border: 3px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        padding: 12px 25px;
        box-shadow: 6px 6px 0px 0px #000;
        transition: 0.1s;
        cursor: pointer;
        display: inline-block;
        color: #000;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .btn-retro:hover {
        background-color: #ffff00; /* Neon Yellow on hover */
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    .btn-save   { background-color: #00ff41; }
    .btn-cancel { background-color: #fff; }
    .btn-list   { background-color: #ffff00; }
</style>

<div class="container retro-container">
    <div class="form-wrapper">
        <h1 class="page-title">Edit User:</h1>

        <div class="action-card">
            <a href="/admin/users" class="btn-retro">Manage Users</a>
        </div>

        <div class="card-retro">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Email (Locked)</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control-retro form-control-readonly" readonly>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="" class="form-control-retro" placeholder="ENTER FIRST NAME">
                    </div>
                    <div class="col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="" class="form-control-retro" placeholder="ENTER LAST NAME">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Contact No.</label>
                        <input type="text" name="contact_no" value="" class="form-control-retro" placeholder="+63 XXX XXX XXXX">
                    </div>
                    <div class="col-md-6">
                        <label>System Role</label>
                        <select name="role" class="form-control-retro">
                            <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control-retro" rows="3" placeholder="ENTER FULL ADDRESS"></textarea>
                </div>

                <div class="mb-4">
                    <label>Profile Image</label>
                    @if($user->photo)
                        <div class="profile-asset-box">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" width="120" style="border: 1px solid #000;">
                            <div style="font-size: 0.6rem; font-weight: 900; margin-top: 5px; text-align: center;">CURRENT_AVATAR.JPG</div>
                        </div>
                    @endif
                    <input type="file" name="photo" class="form-control-retro" accept="image/*" style="background: #eee;">
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <button type="submit" class="btn-retro btn-save">Save Changes</button>
                    <a href="{{ route('admin.users.index') }}" class="btn-retro btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection