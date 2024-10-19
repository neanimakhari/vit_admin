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
                <!-- Add more fields here as needed, such as email and password -->
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-teal-custom hover:bg-teal-custom-dark text-white font-bold py-2 px-4 rounded">
                    Create App User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
