@extends('admin.layouts.app')

@section('title', 'Edit Vehicle Income')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium">Edit Vehicle Income</h3>

    <div class="mt-8">
        <form action="{{ route('admin.vehicle-incomes.update', $vehicleIncome->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="vehicle" class="block text-sm font-medium text-gray-700">Vehicle</label>
                    <input type="text" name="vehicle" id="vehicle" value="{{ old('vehicle', $vehicleIncome->vehicle) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="driver_name" class="block text-sm font-medium text-gray-700">Driver Name</label>
                    <input type="text" name="driver_name" id="driver_name" value="{{ old('driver_name', $vehicleIncome->driver_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="starting_km" class="block text-sm font-medium text-gray-700">Starting KM</label>
                    <input type="number" name="starting_km" id="starting_km" value="{{ old('starting_km', $vehicleIncome->starting_km) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="end_km" class="block text-sm font-medium text-gray-700">End KM</label>
                    <input type="number" name="end_km" id="end_km" value="{{ old('end_km', $vehicleIncome->end_km) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="income" class="block text-sm font-medium text-gray-700">Income</label>
                    <input type="number" step="0.01" name="income" id="income" value="{{ old('income', $vehicleIncome->income) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="logged_on" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="logged_on" id="logged_on" value="{{ old('logged_on', $vehicleIncome->logged_on->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <!-- Add other fields as needed -->

            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Vehicle Income</button>
            </div>
        </form>
    </div>
</div>
@endsection
