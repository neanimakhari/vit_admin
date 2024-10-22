<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncome;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'month');
        $duration = $request->input('duration', 12);

        $endDate = Carbon::now()->endOfDay();
        $startDate = $this->getStartDate($period, $duration);

        // Fetch data from database
        $driverIncomes = $this->getDriverIncomes($startDate, $endDate, $period);
        $vehicleIncomes = $this->getVehicleIncomes($startDate, $endDate, $period);

        $totalIncome = VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])->sum('income');
        $totalExpense = VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])->sum('expense_price');
        $totalDistance = VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])->sum(DB::raw('end_km - starting_km'));
        $totalPetrolLitres = VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])->sum('petrol_litres');

        $vehicleStats = VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])
            ->groupBy('vehicle')
            ->select(
                'vehicle',
                DB::raw('SUM(income) as checking'),
                DB::raw('SUM(expense_price) as expense'),
                DB::raw('SUM(income + expense_price) as income'),
                DB::raw('SUM(petrol_poured) as total_petrol_cost'),
                DB::raw('SUM(petrol_litres) as total_petrol_litres'),
                DB::raw('SUM(end_km - starting_km) as total_kilometers'),
                DB::raw('SUM(income + expense_price) / NULLIF(SUM(end_km - starting_km), 0) as income_per_km'),
                DB::raw('SUM(end_km - starting_km) / NULLIF(SUM(petrol_litres), 0) as km_per_liter')
            )
            ->get();

        $driverStats = VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])
            ->groupBy('driver_name')
            ->select(
                'driver_name',
                DB::raw('SUM(income) as checking'),
                DB::raw('SUM(expense_price) as expense'),
                DB::raw('SUM(income + expense_price) as income'),
                DB::raw('SUM(petrol_poured) as total_petrol_cost'),
                DB::raw('SUM(petrol_litres) as total_petrol_litres'),
                DB::raw('SUM(end_km - starting_km) as total_kilometers'),
                DB::raw('SUM(income + expense_price) / NULLIF(SUM(end_km - starting_km), 0) as income_per_km'),
                DB::raw('SUM(end_km - starting_km) / NULLIF(SUM(petrol_litres), 0) as km_per_liter')
            )
            ->get();

        $statistics = [
            'totalChecking' => $totalIncome,
            'totalExpense' => $totalExpense,
            'totalIncome' => $totalIncome + $totalExpense,
            'totalPetrolCost' => VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])->sum('petrol_poured'),
            'totalPetrolLitres' => $totalPetrolLitres,
            'totalDistance' => $totalDistance,
            'averageIncomePerKm' => $totalDistance > 0 ? $totalIncome / $totalDistance : 0,
            'fuelEfficiency' => $totalPetrolLitres > 0 ? $totalDistance / $totalPetrolLitres : 0,
            'mostActiveVehicle' => VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])
                ->groupBy('vehicle')
                ->select('vehicle', DB::raw('COUNT(*) as count'))
                ->orderByDesc('count')
                ->first(),
            'topEarningDriver' => VehicleIncome::whereBetween('logged_on', [$startDate, $endDate])
                ->groupBy('driver_name')
                ->select('driver_name', DB::raw('SUM(income) as total_income'))
                ->orderByDesc('total_income')
                ->first(),
            'vehicleStats' => $vehicleStats,
            'driverStats' => $driverStats,
            'driverIncomes' => $driverIncomes,
            'vehicleIncomes' => $vehicleIncomes,
        ];

        $driverIncomeChart = $this->createDriverIncomeChart($driverIncomes);
        $vehicleIncomeChart = $this->createVehicleIncomeChart($vehicleIncomes);
        $incomeExpenseChart = $this->createIncomeExpenseChart($statistics['totalIncome'], $statistics['totalExpense']);
        $vehiclePerformanceChart = $this->createVehiclePerformanceChart($statistics['vehicleStats']);

        return view('admin.dashboard', compact('statistics', 'period', 'duration', 'driverIncomeChart', 'vehicleIncomeChart', 'incomeExpenseChart', 'vehiclePerformanceChart'));
    }

    private function getStartDate($period, $duration)
    {
        $now = Carbon::now();
        switch ($period) {
            case 'week':
                return $now->subWeeks($duration)->startOfWeek();
            case 'month':
                return $now->subMonths($duration)->startOfMonth();
            case 'year':
                return $now->subYears($duration)->startOfYear();
            default:
                return $now->subMonths($duration)->startOfMonth();
        }
    }

    private function getGroupBy($period)
    {
        switch ($period) {
            case 'week':
                return '%Y-%u';
            case 'month':
                return '%Y-%m';
            case 'year':
                return '%Y';
            default:
                return '%Y-%m';
        }
    }

    private function getDriverIncomes($startDate, $endDate, $period)
    {
        $groupBy = $this->getGroupBy($period);
        return VehicleIncome::select(
            'driver_name',
            DB::raw("DATE_FORMAT(logged_on, '{$groupBy}') as date"),
            DB::raw('SUM(income) as total_income')
        )
        ->whereBetween('logged_on', [$startDate, $endDate])
        ->groupBy('driver_name', 'date')
        ->orderBy('date')
        ->get()
        ->groupBy('driver_name')
        ->map(function ($items) {
            return $items->pluck('total_income', 'date')->toArray();
        });
    }

    private function getVehicleIncomes($startDate, $endDate, $period)
    {
        $groupBy = $this->getGroupBy($period);
        return VehicleIncome::select(
            'vehicle',
            DB::raw("DATE_FORMAT(logged_on, '{$groupBy}') as date"),
            DB::raw('SUM(income) as total_income')
        )
        ->whereBetween('logged_on', [$startDate, $endDate])
        ->groupBy('vehicle', 'date')
        ->orderBy('date')
        ->get()
        ->groupBy('vehicle')
        ->map(function ($items) {
            return $items->pluck('total_income', 'date')->toArray();
        });
    }

    private function createDriverIncomeChart($driverIncomes)
    {
        $labels = array_keys(reset($driverIncomes));
        $datasets = [];

        foreach ($driverIncomes as $driver => $incomes) {
            $datasets[] = [
                'label' => $driver,
                'data' => array_values($incomes),
                'backgroundColor' => $this->getRandomColor(0.7),
                'borderColor' => $this->getRandomColor(1),
                'fill' => false,
            ];
        }

        return Chartjs::build()
            ->name('DriverIncomeChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets($datasets)
            ->options([
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'callback' => "function(value) { return 'R ' + value.toLocaleString('en-ZA'); }"
                        ]
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Driver Income Trends'
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => "function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'R ' + context.parsed.y.toLocaleString('en-ZA');
                                return label;
                            }"
                        ]
                    ]
                ]
            ]);
    }

    private function createVehicleIncomeChart($vehicleIncomes)
    {
        $labels = array_keys(reset($vehicleIncomes));
        $datasets = [];

        foreach ($vehicleIncomes as $vehicle => $incomes) {
            $datasets[] = [
                'label' => $vehicle,
                'data' => array_values($incomes),
                'backgroundColor' => $this->getRandomColor(0.7),
                'borderColor' => $this->getRandomColor(1),
                'fill' => false,
            ];
        }

        return Chartjs::build()
            ->name('VehicleIncomeChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets($datasets)
            ->options([
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'callback' => "function(value) { return 'R ' + value.toLocaleString('en-ZA'); }"
                        ]
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Vehicle Income Trends'
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => "function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'R ' + context.parsed.y.toLocaleString('en-ZA');
                                return label;
                            }"
                        ]
                    ]
                ]
            ]);
    }

    private function createIncomeExpenseChart($totalIncome, $totalExpense)
    {
        return Chartjs::build()
            ->name('IncomeExpenseChart')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Income', 'Expense'])
            ->datasets([
                [
                    'backgroundColor' => ['#34D399', '#F87171'],
                    'data' => [$totalIncome, $totalExpense]
                ]
            ])
            ->options([
                'responsive' => true,
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom',
                    ]
                ]
            ]);
    }

    private function createVehiclePerformanceChart($vehicleStats)
    {
        $labels = $vehicleStats->pluck('vehicle')->toArray();
        $data = $vehicleStats->pluck('total_kilometers')->toArray();

        return Chartjs::build()
            ->name('VehiclePerformanceChart')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    'label' => 'Total Distance (km)',
                    'backgroundColor' => '#60A5FA',
                    'data' => $data
                ]
            ])
            ->options([
                'responsive' => true,
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom',
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]);
    }

    private function getChartTimeUnit($period)
    {
        switch ($period) {
            case 'week':
                return 'day';
            case 'month':
                return 'week';
            case 'year':
                return 'month';
            default:
                return 'week';
        }
    }

    private function getRandomColor($opacity = 1)
    {
        return 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',' . $opacity . ')';
    }
}
