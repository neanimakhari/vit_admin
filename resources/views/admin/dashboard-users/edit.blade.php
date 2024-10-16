@extends('admin.layouts.app')

@section('title', 'Edit Dashboard User')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium mb-6">Edit Dashboard User</h3>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.dashboard-users.update', $dashboardUser) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom" value="{{ old('name', $dashboardUser->name) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom" value="{{ old('email', $dashboardUser->email) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">New Password (leave blank to keep current)</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom">
            </div>
            
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-teal-custom hover:bg-teal-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update User
                </button>
                <a href="{{ route('admin.dashboard-users.index') }}" class="text-teal-custom hover:text-teal-dark">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
