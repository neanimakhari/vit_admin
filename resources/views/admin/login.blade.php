<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-500 to-teal-500 h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-10 py-12">
            <!-- Title -->
            
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Admin Login</h2>
            
            <!-- Error Message -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">The provided credentials do not match our records.</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="you@example.com" required autofocus>
                </div>
                
                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="••••••••" required>
                </div>

                <!-- Login Button and Forgot Password Link -->
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                        Login
                    </button>
                    <a href="#" class="text-sm font-bold text-blue-500 hover:text-blue-800">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
