<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Global Retro Theme */
        body {
            background-color: #ffffff;
            font-family: 'Courier New', Courier, monospace;
            background-image:
                linear-gradient(#d0d0d0 1px, transparent 1px),
                linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* Retro Navbar - Solid Black */
        .navbar {
            border-bottom: 3px solid #000 !important;
            background-color: #000 !important;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            font-size: 1.5rem;
            color: #fff !important;
        }

        .nav-link {
            text-transform: uppercase;
            font-weight: bold;
            color: #fff !important;
            letter-spacing: 1px;
        }

        .nav-link:hover {
            color: #d0d0d0 !important;
        }

        /* Retro Dropdown Customization */
        .dropdown-menu {
            border: 3px solid #000 !important;
            border-radius: 0 !important;
            box-shadow: 6px 6px 0px 0px #000;
            padding: 0;
            background-color: #fff;
        }

        .dropdown-item {
            font-weight: bold;
            text-transform: uppercase;
            padding: 12px 20px;
            border-bottom: 2px solid #000;
            color: #000;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: #000 !important;
            color: #fff !important;
        }

        /* Navbar Toggler for Mobile */
        .navbar-toggler {
            background-color: #fff !important;
            border: 2px solid #000 !important;
            border-radius: 0 !important;
        }

        main {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-none">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>

                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if(Auth::user()->hasRole('customer'))
                                <li class="nav-item">
                                    <a class="nav-link px-3" href="{{ route('cart.index') }}">
                                        <i class="bi bi-cart-fill"></i> Cart
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('account.edit') }}">
                                        My Account
                                    </a>

                                    <a class="dropdown-item" href="{{ route('account.password.form') }}">
                                        Change Password
                                    </a>

                                    @if(Auth::user()->hasRole('customer'))
                                        <a class="dropdown-item" href="{{ route('account.orders') }}">
                                            My Orders
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    @stack('scripts')
</body>
</html>
