@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
    <p class="mb-6">Welcome, {{ Auth::user()->name }}! You have admin access.</p>

    <div class="grid grid-cols-3 gap-6">
        <!-- Products -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-xl font-semibold mb-2">Manage Products</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Go to Products</a>
        </div>

        <!-- Categories -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-xl font-semibold mb-2">Manage Categories</h2>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Go to Categories</a>
        </div>

        <!-- Orders -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-xl font-semibold mb-2">Manage Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Go to Orders</a>
        </div>

        <!-- Users -->
        @role('admin')
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-xl font-semibold mb-2">Manage Users</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Go to Users</a>
        </div>
        @endrole

        <!-- Reviews -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-xl font-semibold mb-2">Manage Reviews</h2>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary">Go to Reviews</a>
        </div>

        <!-- Reports / Analytics -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-xl font-semibold mb-2">Reports / Analytics</h2>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">View Reports</a>
        </div>
    </div>
</div>
@endsection
