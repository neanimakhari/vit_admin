<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Vit Dashboard')</title>

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
<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="sidebar w-64 space-y-6 py-7 px-2">
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
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        @yield('header')
                    </h1>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
