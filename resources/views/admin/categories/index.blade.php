@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist Layout */
    body {
        background-color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        background-image:
            linear-gradient(#d0d0d0 1px, transparent 1px),
            linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .retro-container {
        padding: 40px 20px;
    }

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        text-transform: uppercase;
        margin-bottom: 25px;
        letter-spacing: -1px;
    }

    /* Success Alert */
    .alert-retro {
        background-color: #00ff41;
        color: #000;
        border: 3px solid #000;
        padding: 15px;
        font-weight: bold;
        margin-bottom: 20px;
        box-shadow: 6px 6px 0px 0px #000;
        text-transform: uppercase;
    }

    /* Main Action Button */
    .btn-retro-primary {
        background-color: #fff;
        color: #000;
        border: 3px solid #000;
        padding: 12px 20px;
        font-weight: 900;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-block;
        box-shadow: 6px 6px 0px 0px #000;
        transition: all 0.1s;
        margin-bottom: 30px;
    }

    .btn-retro-primary:hover {
        transform: translate(2px, 2px);
        box-shadow: 4px 4px 0px 0px #000;
        background-color: #ffff00; /* Neon Yellow */
    }

    /* Table Styling */
    .retro-table-card {
        border: 4px solid #000;
        box-shadow: 12px 12px 0px 0px #000;
        background-color: #fff;
        overflow: hidden;
    }

    .retro-table {
        width: 100%;
        border-collapse: collapse;
    }

    .retro-table th {
        background-color: #000;
        color: #fff;
        text-transform: uppercase;
        padding: 15px;
        text-align: left;
        letter-spacing: 1px;
    }

    .retro-table td {
        padding: 15px;
        border-bottom: 2px solid #000;
        font-weight: bold;
        vertical-align: middle;
    }

    /* Small Action Buttons */
    .btn-action-sm {
        border: 2px solid #000;
        padding: 6px 12px;
        font-size: 0.75rem;
        background: #fff;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        text-decoration: none;
        box-shadow: 3px 3px 0px 0px #000;
        margin-right: 5px;
        display: inline-block;
        cursor: pointer;
    }

    .btn-action-sm:hover {
        background: #000;
        color: #fff;
        box-shadow: none;
        transform: translate(2px, 2px);
    }

    .btn-edit-retro { background-color: #00ff41; } /* Green */
    .btn-delete-retro { background-color: #ff3e3e; } /* Red */

</style>

<div class="container retro-container">
    <h1 class="page-title">Manage Categories</h1>

    @if(session('success'))
        <div class="alert-retro">
            [SYSTEM_LOG]: {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.categories.create') }}" class="btn-retro-primary">
        Add New Category +
    </a>

    <div class="retro-table-card">
        <table class="retro-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>#{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-action-sm btn-edit-retro">
                            Edit
                        </a>

                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-sm btn-delete-retro"
                                    onclick="return confirm('SYSTEM WARNING: Delete this category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
