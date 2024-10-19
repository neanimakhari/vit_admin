@extends('admin.layouts.app')

@section('title', 'Edit Dashboard User')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium mb-6">Edit Dashboard User</h3>
    
    @if(isset($user))
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.dashboard-users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom @error('password') border-red-500 @enderror">
                    <p class="text-gray-600 text-xs mt-1">Leave blank to keep the current password</p>
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-teal-custom">
                </div>
                
                <div class="flex items-center justify-between mt-8">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update User
                    </button>
                    <a href="{{ route('admin.dashboard-users.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
