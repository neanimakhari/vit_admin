@extends('admin.layouts.app')

@section('title', 'Vehicle Incomes')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium">Vehicle Incomes</h3>

    <div class="mt-8">
        <a href="{{ route('admin.vehicle-incomes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Vehicle Income
        </a>
    </div>

    <div class="mt-6">
        <form action="{{ route('admin.vehicle-incomes.index') }}" method="GET" class="mb-4">
            <div class="flex flex-wrap -mx-2 space-y-4 md:space-y-0">
                <div class="w-full px-2 md:w-1/4">
                    <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline" type="text" name="vehicle" placeholder="Filter by vehicle" value="{{ request('vehicle') }}">
                </div>
                <div class="w-full px-2 md:w-1/4">
                    <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline" type="text" name="driver" placeholder="Filter by driver" value="{{ request('driver') }}">
                </div>
                <div class="w-full px-2 md:w-1/4">
                    <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline" type="date" name="date_from" placeholder="From date" value="{{ request('date_from') }}">
                </div>
                <div class="w-full px-2 md:w-1/4">
                    <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline" type="date" name="date_to" placeholder="To date" value="{{ request('date_to') }}">
                </div>
                <div class="w-full px-2 md:w-1/4">
                    <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline" type="month" name="month" placeholder="Filter by month" value="{{ request('month') }}">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Apply Filters</button>
                <a href="{{ route('admin.vehicle-incomes.index') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Clear Filters</a>
            </div>
        </form>
    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Income</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($vehicleIncomes as $income)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $income->logged_on ? $income->logged_on->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $income->vehicle }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $income->driver_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ number_format($income->income, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <a href="{{ route('admin.vehicle-incomes.show', $income->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                                    <a href="{{ route('admin.vehicle-incomes.edit', $income->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                    <form action="{{ route('admin.vehicle-incomes.destroy', $income->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 flex space-x-2">
        <a href="{{ route('admin.vehicle-incomes.export-pdf') }}" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Export PDF</a>
        <a href="{{ route('admin.vehicle-incomes.export-word') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Export Word</a>
    </div>

    <div class="mt-4">
        {{ $vehicleIncomes->links() }}
    </div>
</div>
@endsection
