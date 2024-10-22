@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <h2 class="text-2xl font-semibold leading-tight py-6">Dashboard</h2>

    <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-8">
        <div class="flex items-center space-x-4">
            <select name="period" class="form-select">
                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Weekly</option>
                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Monthly</option>
                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Yearly</option>
            </select>
            <input type="number" name="duration" value="{{ $duration }}" min="1" max="60" class="form-input w-20">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update
            </button>
        </div>
    </form>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Total Income</h3>
            <p class="text-3xl font-bold text-green-600">R {{ number_format($statistics['totalIncome'], 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Total Expense</h3>
            <p class="text-3xl font-bold text-red-600">R {{ number_format($statistics['totalExpense'], 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Total Distance</h3>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($statistics['totalDistance'], 2) }} km</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Total Petrol Cost</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ number_format($statistics['totalPetrolCost'], 2) }}</p>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Efficiency Metrics</h3>
            <ul class="space-y-2">
                <li>Average Income per Km: 
                    @if($statistics['totalDistance'] > 0)
                        {{ number_format($statistics['averageIncomePerKm'], 2) }}
                    @else
                        N/A
                    @endif
                </li>
                <li>Fuel Efficiency: 
                    @if($statistics['totalPetrolLitres'] > 0)
                        {{ number_format($statistics['fuelEfficiency'], 2) }} km/L
                    @else
                        N/A
                    @endif
                </li>
                <li>Petrol Cost per Km: 
                    @if($statistics['totalDistance'] > 0)
                        {{ number_format($statistics['totalPetrolCost'] / $statistics['totalDistance'], 2) }}
                    @else
                        N/A
                    @endif
                </li>
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Top Performers</h3>
            <ul class="space-y-2">
                <li>Most Active Vehicle: 
                    @if($statistics['mostActiveVehicle'])
                        {{ $statistics['mostActiveVehicle']->vehicle }} ({{ $statistics['mostActiveVehicle']->count }} trips)
                    @else
                        N/A
                    @endif
                </li>
                <li>Top Earning Driver: 
                    @if($statistics['topEarningDriver'])
                        {{ $statistics['topEarningDriver']->driver_name }} ({{ number_format($statistics['topEarningDriver']->total_income, 2) }})
                    @else
                        N/A
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Income vs Expense</h3>
            <x-chartjs-component :chart="$incomeExpenseChart" />
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Vehicle Performance</h3>
            <x-chartjs-component :chart="$vehiclePerformanceChart" />
        </div>
    </div>

    <!-- Driver Income Trends Graph -->
    <div class="mt-8">
        <h4 class="text-gray-600 text-lg font-medium mb-4">Driver Income Trends</h4>
        <div class="bg-white rounded-lg shadow-md p-6">
            <x-chartjs-component :chart="$driverIncomeChart" />
        </div>
    </div>

    <!-- Vehicle Income Trends Graph -->
    <div class="mt-8">
        <h4 class="text-gray-600 text-lg font-medium mb-4">Vehicle Income Trends</h4>
        <div class="bg-white rounded-lg shadow-md p-6">
            <x-chartjs-component :chart="$vehicleIncomeChart" />
        </div>
    </div>

    <!-- Vehicle Statistics Table -->
    <div class="mt-8">
        <h4 class="text-gray-600 text-lg font-medium mb-4">Vehicle Statistics</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Checking</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Income</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petrol Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petrol Litres</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kilometers</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Income/Km</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Km/Liter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistics['vehicleStats'] as $stat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stat->vehicle }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->checking, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->expense, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->income, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->total_petrol_cost, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($stat->total_petrol_litres, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($stat->total_kilometers, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->income_per_km, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($stat->km_per_liter, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Driver Statistics Table -->
    <div class="mt-8">
        <h4 class="text-gray-600 text-lg font-medium mb-4">Driver Statistics</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Checking</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Income</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petrol Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petrol Litres</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kilometers</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Income/Km</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Km/Liter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistics['driverStats'] as $stat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stat->driver_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->checking, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->expense, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->income, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->total_petrol_cost, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($stat->total_petrol_litres, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($stat->total_kilometers, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">R {{ number_format($stat->income_per_km, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($stat->km_per_liter, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
