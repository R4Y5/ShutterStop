@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist Dashboard Styling */
    .dashboard-container {
        padding: 40px 20px;
    }

    .dashboard-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 3rem;
        letter-spacing: -1px;
        margin-bottom: 10px;
    }

    .welcome-banner {
        background-color: #00ff41;
        color: #000;
        display: inline-block;
        padding: 5px 15px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 40px;
        border: 2px solid #000;
    }

    /* Grid Card Styling */
    .admin-card {
        background-color: #fff;
        border: 4px solid #000;
        border-radius: 0 !important;
        box-shadow: 10px 10px 0px 0px #000;
        transition: all 0.2s ease;
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .admin-card:hover {
        transform: translate(-4px, -4px);
        box-shadow: 14px 14px 0px 0px #000;
    }

    .card-title-retro {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 1.25rem;
        margin-bottom: 15px;
        line-height: 1;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    /* Button Styling */
    .btn-admin-retro {
        background-color: #fff;
        color: #000;
        border: 3px solid #000;
        padding: 10px 15px;
        font-weight: 900;
        text-transform: uppercase;
        text-decoration: none;
        display: block;
        text-align: center;
        box-shadow: 5px 5px 0px 0px #000;
        transition: all 0.1s;
    }

    .btn-admin-retro:hover {
        background-color: #ffff00; /* Neon Yellow on hover */
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000;
        color: #000;
    }

    /* Specific Accent for Admin/User management */
    .user-accent {
        background-color: #f0f0f0;
    }
</style>

<div class="container dashboard-container">
    <h1 class="dashboard-title">System Admin</h1>
    <div class="welcome-banner">
        STATUS: ONLINE
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="card-title-retro">Manage Products</h2>
                <p class="small text-uppercase font-weight-bold">Inventory & Pricing Control</p>
                <a href="{{ route('admin.products.index') }}" class="btn-admin-retro">Open Terminal</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="card-title-retro">Manage Categories</h2>
                <p class="small text-uppercase font-weight-bold">Organization & Taxonomies</p>
                <a href="{{ route('admin.categories.index') }}" class="btn-admin-retro">Open Terminal</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="card-title-retro">Manage Orders</h2>
                <p class="small text-uppercase font-weight-bold">Fulfillment & Tracking</p>
                <a href="{{ route('admin.orders.index') }}" class="btn-admin-retro">Open Terminal</a>
            </div>
        </div>

        @role('admin')
        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="card-title-retro">Manage Users</h2>
                <p class="small text-uppercase font-weight-bold">Access Control & Roles</p>
                <a href="{{ route('admin.users.index') }}" class="btn-admin-retro">Open Terminal</a>
            </div>
        </div>
        @endrole

        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="card-title-retro">Manage Reviews</h2>
                <p class="small text-uppercase font-weight-bold">Moderation & Feedback</p>
                <a href="{{ route('admin.reviews.index') }}" class="btn-admin-retro">Open Terminal</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="admin-card h-100">
                <h2 class="card-title-retro">Reports / Analytics</h2>
                <p class="small text-uppercase font-weight-bold">Data & Performance Stats</p>
                <a href="{{ route('admin.reports.analytics') }}" class="btn-admin-retro">View Reports</a>
            </div>
        </div>
    </div>
</div>
@endsection
