<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncome;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $statistics = [
            'totalIncome' => VehicleIncome::whereYear('logged_on', $currentYear)
                ->whereMonth('logged_on', $currentMonth)
                ->sum('income'),
            'totalExpense' => VehicleIncome::whereYear('logged_on', $currentYear)
                ->whereMonth('logged_on', $currentMonth)
                ->sum('expense_price'),
            'totalPetrolCost' => VehicleIncome::whereYear('logged_on', $currentYear)
                ->whereMonth('logged_on', $currentMonth)
                ->sum('petrol_poured'),
            'totalPetrolLitres' => VehicleIncome::whereYear('logged_on', $currentYear)
                ->whereMonth('logged_on', $currentMonth)
                ->sum('petrol_litres'),
            'totalKilometers' => VehicleIncome::whereYear('logged_on', $currentYear)
                ->whereMonth('logged_on', $currentMonth)
                ->sum(DB::raw('end_km - starting_km')),
            'vehicleStats' => VehicleIncome::whereYear('logged_on', $currentYear)
                ->whereMonth('logged_on', $currentMonth)
                ->groupBy('vehicle')
                ->select('vehicle', 
                    DB::raw('SUM(income) as total_income'),
                    DB::raw('SUM(expense_price) as total_expense'),
                    DB::raw('SUM(petrol_poured) as total_petrol_cost'),
                    DB::raw('SUM(petrol_litres) as total_petrol_litres'),
                    DB::raw('SUM(end_km - starting_km) as total_kilometers')
                )
                ->get(),
            'driverStats' => VehicleIncome::whereYear('logged_on', $currentYear)
                ->whereMonth('logged_on', $currentMonth)
                ->groupBy('driver_id', 'driver_name')
                ->select('driver_id', 'driver_name', 
                    DB::raw('SUM(income) as total_income'),
                    DB::raw('SUM(expense_price) as total_expense'),
                    DB::raw('SUM(petrol_poured) as total_petrol_cost'),
                    DB::raw('SUM(petrol_litres) as total_petrol_litres'),
                    DB::raw('SUM(end_km - starting_km) as total_kilometers')
                )
                ->get(),
        ];

        return view('admin.dashboard', compact('statistics'));
    }
}
