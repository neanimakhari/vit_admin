<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vehicle Income Tracker | Makhari Transport</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <style>
        .bg-dark-teal { background-color: #005f73; }
        .text-dark-teal { color: #005f73; }
        .hover\:bg-dark-teal-600:hover { background-color: #0a9396; }
        .focus\:ring-dark-teal:focus { --tw-ring-color: #005f73; }
        .focus\:border-dark-teal:focus { border-color: #005f73; }
        .text-dark-teal-500 { color: #0a9396; }
        body {
            background-image: url('{{ asset('images/water.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between" x-data="{ showPassword: false }">
    <div class="flex-grow flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white bg-opacity-90 p-6 rounded-lg shadow-lg">
            <div>
                <img src="{{ asset('images/vit_logo.png') }}" alt="VIT Logo" class="mx-auto h-24 w-auto">
                <h1 class="mt-4 text-center text-2xl font-extrabold text-dark-teal">Vehicle Income Tracker</h1>
                <p class="text-center text-sm text-gray-600">Makhari Transport</p>
                <h2 class="mt-4 text-center text-xl font-bold text-gray-900">Welcome Back!</h2>
                <p class="text-center text-sm text-gray-600">Please sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 text-sm" role="alert">
                    <p class="font-bold">Oops!</p>
                    <p>The provided credentials do not match our records.</p>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('admin.login.submit') }}" x-data="{ showPassword: false }">
                @csrf
                <div class="rounded-md shadow-sm space-y-2">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-dark-teal focus:border-dark-teal focus:z-10 sm:text-sm" placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="flex items-center">
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-l-md focus:outline-none focus:ring-dark-teal focus:border-dark-teal focus:z-10 sm:text-sm" placeholder="Enter your password">
                            <button type="button" @click="showPassword = !showPassword" class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 text-sm leading-5 font-medium rounded-r-md text-gray-700 bg-gray-50 hover:text-gray-500 focus:outline-none focus:ring-1 focus:ring-dark-teal active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                <svg x-show="!showPassword" class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-dark-teal focus:ring-dark-teal border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-dark-teal hover:text-teal-500">Forgot password?</a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-dark-teal hover:bg-dark-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-teal">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="py-4 text-center text-xs text-white bg-black bg-opacity-50">
        <p>&copy; {{ date('Y') }} Neani Makhari - Changing the world one line of code at a time</p>
        <p class="mt-1">
            <a href="#" class="text-white hover:underline">Privacy Policy</a> | 
            <a href="#" class="text-white hover:underline">Terms of Service</a>
        </p>
    </footer>
</body>
</html>
