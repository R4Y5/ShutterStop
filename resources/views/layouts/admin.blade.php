<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-dark text-white p-3" style="width:250px; min-height:100vh;">
            <h4 class="mb-4">Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.products.index') }}" class="nav-link text-white">Manage Products</a></li>
                <li class="nav-item"><a href="{{ route('admin.categories.index') }}" class="nav-link text-white">Manage Categories</a></li>
                <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link text-white">Manage Users</a></li>
                <li class="nav-item"><a href="{{ route('admin.orders.index') }}" class="nav-link text-white">Manage Orders</a></li>
                <li class="nav-item"><a href="{{ route('admin.reviews.index') }}" class="nav-link text-white">Manage Reviews</a></li>
                <li class="nav-item"><a href="{{ route('admin.reports.index') }}" class="nav-link text-white">Reports / Analytics</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
</body>
</html>
