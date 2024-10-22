@extends('admin.layouts.app')

@section('title', 'Add Vehicle Income')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium">Add Vehicle Income</h3>

    <div class="mt-8">
        <form action="{{ route('admin.vehicle-incomes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="vehicle_id" class="block text-sm font-medium text-gray-700">Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="">Select a vehicle</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="driver_id" class="block text-sm font-medium text-gray-700">Driver</label>
                    <select name="driver_id" id="driver_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="">Select a driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="starting_km" class="block text-sm font-medium text-gray-700">Starting KM</label>
                    <input type="number" name="starting_km" id="starting_km" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>

                <div>
                    <label for="end_km" class="block text-sm font-medium text-gray-700">End KM</label>
                    <input type="number" name="end_km" id="end_km" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>

                <div>
                    <label for="income" class="block text-sm font-medium text-gray-700">Income</label>
                    <input type="number" step="0.01" name="income" id="income" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>

                <div>
                    <label for="petrol_poured" class="block text-sm font-medium text-gray-700">Petrol Poured</label>
                    <input type="number" step="0.01" name="petrol_poured" id="petrol_poured" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>

                <div>
                    <label for="petrol_litres" class="block text-sm font-medium text-gray-700">Petrol Litres</label>
                    <input type="number" step="0.01" name="petrol_litres" id="petrol_litres" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>

                <div>
                    <label for="logged_on" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="logged_on" id="logged_on" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>

                <div>
                    <label for="expense_detail" class="block text-sm font-medium text-gray-700">Expense Detail</label>
                    <input type="text" name="expense_detail" id="expense_detail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="expense_price" class="block text-sm font-medium text-gray-700">Expense Price</label>
                    <input type="number" step="0.01" name="expense_price" id="expense_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="expense_image" class="block text-sm font-medium text-gray-700">Expense Image</label>
                    <input type="file" name="expense_image" id="expense_image" class="mt-1 block w-full">
                </div>

                <div>
                    <label for="petrol_slip" class="block text-sm font-medium text-gray-700">Petrol Slip</label>
                    <input type="file" name="petrol_slip" id="petrol_slip" class="mt-1 block w-full">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Vehicle Income</button>
            </div>
        </form>
    </div>
</div>
@endsection
