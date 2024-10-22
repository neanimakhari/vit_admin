<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Vit Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            background-color: #e2e8f0; /* Darker background */
        }
        .sidebar {
            background-color: #1a202c; /* Keep sidebar dark */
            color: #e2e8f0;
        }
        .sidebar a {
            color: #e2e8f0;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #2d3748;
        }
        .main-content {
            background-color: #f1f5f9; /* Slightly darker than body */
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .btn-action {
            background-color: #1a365d; /* Keep the dark blue for buttons */
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.1s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn-action:hover {
            background-color: #2c5282;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-action:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .admin-table th {
            background-color: #2d3748;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.875rem;
        }
        .admin-table td {
            background-color: #f8fafc;
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .admin-table tr:last-child td {
            border-bottom: none;
        }
        .admin-table tr:nth-child(even) td {
            background-color: #edf2f7;
        }
        .admin-table tr:hover td {
            background-color: #e2e8f0;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-full md:w-64 md:min-h-screen">
            <div class="flex flex-col items-center space-y-2 px-4">
                <img src="{{ asset('images/vit_logo.png') }}" alt="VIT Logo" class="w-16 h-16 object-contain">
                <span class="text-2xl font-extrabold text-white">VIT Dashboard</span>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 flex items-center text-white hover:bg-gray-700">
                    <i class="fas fa-tachometer-alt w-6 text-lg"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('admin.app-users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 flex items-center text-white hover:bg-gray-700">
                    <i class="fas fa-users w-6 text-lg"></i>
                    <span class="ml-3">App Users</span>
                </a>
                <a href="{{ route('admin.dashboard-users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 flex items-center text-white hover:bg-gray-700">
                    <i class="fas fa-user-cog w-6 text-lg"></i>
                    <span class="ml-3">Dashboard Users</span>
                </a>
                <a href="{{ route('admin.vehicle-incomes.index') }}" class="block py-2.5 px-4 rounded transition duration-200 flex items-center text-white hover:bg-gray-700">
                    <i class="fas fa-money-bill-wave w-6 text-lg"></i>
                    <span class="ml-3">Vehicle Incomes</span>
                </a>
                <a href="{{ route('admin.driver-salaries.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Driver Salaries
                </a>
            </nav>

            <!-- User Info -->
            <div class="pt-4 mt-4 border-t border-gray-700">
                <div class="flex items-center space-x-4 px-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">
                            {{ Auth::user()->name ?? 'User Name' }}
                        </p>
                        <p class="text-xs text-gray-400 truncate">
                            {{ Auth::user()->email ?? 'user@example.com' }}
                        </p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="btn-primary w-full">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <!-- Top Navbar -->
            <nav class="bg-white shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        @yield('header')
                    </h1>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container mx-auto px-4 py-8">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
