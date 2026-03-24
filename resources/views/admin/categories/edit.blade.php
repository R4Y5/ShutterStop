@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist Layout Base */
    body {
        background-color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        background-image:
            linear-gradient(#d0d0d0 1px, transparent 1px),
            linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .retro-container {
        padding: 60px 20px;
    }

    .form-wrapper {
        max-width: 500px;
        margin: 0 auto;
    }

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        text-transform: uppercase;
        margin-bottom: 30px;
        text-align: center;
        letter-spacing: -1px;
    }

    /* Card Styling */
    .card-retro {
        border: 4px solid #000 !important;
        border-radius: 0 !important;
        box-shadow: 12px 12px 0px 0px #000;
        background-color: #fff;
        padding: 30px;
    }

    /* Form Elements */
    label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.9rem;
        margin-bottom: 10px;
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
    }

    .form-control-retro:focus {
        box-shadow: 6px 6px 0px 0px #000;
        border-color: #000;
        outline: none;
    }

    /* Button Grouping */
    .btn-group-retro {
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }

    .btn-retro {
        flex: 1;
        border: 3px solid #000;
        padding: 12px;
        font-weight: 900;
        text-transform: uppercase;
        text-decoration: none;
        text-align: center;
        box-shadow: 6px 6px 0px 0px #000;
        transition: all 0.1s;
        cursor: pointer;
        display: inline-block;
        color: #000;
    }

    .btn-retro:hover {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px 0px #000;
    }

    .btn-update {
        background-color: #ffff00; /* Neon Yellow for Update */
    }

    .btn-cancel {
        background-color: #fff;
    }
</style>

<div class="container retro-container">
    <div class="form-wrapper">
        <h1 class="page-title">Edit Category</h1>

        <div class="card-retro">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name"
                           class="form-control-retro"
                           value=""
                           placeholder="UPDATE_NAME_HERE..."
                           required>
                </div>

                <div class="btn-group-retro">
                    <button type="submit" class="btn-retro btn-update">
                        Update Entry
                    </button>

                    <a href="{{ route('admin.categories.index') }}" class="btn-retro btn-cancel">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
