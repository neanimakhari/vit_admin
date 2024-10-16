@extends('admin.layouts.app')

@section('title', 'Create App User')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium">Create New App User</h3>

    <div class="mt-8 bg-white rounded-lg shadow">
        <form action="{{ route('admin.app-users.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone_number" id="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="email_address" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email_address" id="email_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required></textarea>
                </div>
                <div>
                    <label for="license_number" class="block text-sm font-medium text-gray-700">License Number</label>
                    <input type="text" name="license_number" id="license_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="license_expiry_date" class="block text-sm font-medium text-gray-700">License Expiry Date</label>
                    <input type="date" name="license_expiry_date" id="license_expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="isActive" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="isActive" id="isActive" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-custom focus:ring focus:ring-teal-custom focus:ring-opacity-50" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-teal-custom hover:bg-teal-dark text-white font-bold py-2 px-4 rounded">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
