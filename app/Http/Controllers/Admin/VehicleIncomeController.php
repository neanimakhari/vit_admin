<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\VehicleIncome;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class VehicleIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VehicleIncome::query();

        // Apply filters
        if ($request->filled('vehicle')) {
            $query->where('vehicle', 'like', '%' . $request->vehicle . '%');
        }

        if ($request->filled('driver')) {
            $query->where('driver_name', 'like', '%' . $request->driver . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('logged_on', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('logged_on', '<=', $request->date_to);
        }

        if ($request->filled('month')) {
            $query->whereYear('logged_on', '=', substr($request->month, 0, 4))
                  ->whereMonth('logged_on', '=', substr($request->month, 5, 2));
        }

        // Order by logged_on instead of created_at
        $vehicleIncomes = $query->orderBy('logged_on', 'desc')->paginate(10);

        return view('admin.vehicle-incomes.index', compact('vehicleIncomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('admin.vehicle-incomes.create', compact('vehicles', 'drivers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'starting_km' => 'required|numeric',
            'end_km' => 'required|numeric|gt:starting_km',
            'income' => 'required|numeric',
            'petrol_poured' => 'required|numeric',
            'petrol_litres' => 'required|numeric',
            'logged_on' => 'required|date',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'expense_detail' => 'nullable|string',
            'expense_price' => 'nullable|numeric',
            'expense_image' => 'nullable|image|max:2048',
            'petrol_slip' => 'nullable|image|max:2048',
        ]);

        $vehicle = Vehicle::findOrFail($validatedData['vehicle_id']);
        $driver = Driver::findOrFail($validatedData['driver_id']);

        $validatedData['vehicle'] = $vehicle->name;
        $validatedData['driver_name'] = $driver->name;

        if ($request->hasFile('expense_image')) {
            $validatedData['expense_image'] = $request->file('expense_image')->store('expense_images', 'public');
        }

        if ($request->hasFile('petrol_slip')) {
            $validatedData['petrol_slip'] = $request->file('petrol_slip')->store('petrol_slips', 'public');
        }

        VehicleIncome::create($validatedData);

        return redirect()->route('admin.vehicle-incomes.index')->with('success', 'Vehicle Income created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleIncome $vehicleIncome)
    {
        return view('admin.vehicle-incomes.show', compact('vehicleIncome'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleIncome $vehicleIncome)
    {
        return view('admin.vehicle-incomes.edit', compact('vehicleIncome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleIncome $vehicleIncome)
    {
        $validatedData = $request->validate([
            'starting_km' => 'required|numeric',
            'end_km' => 'required|numeric|gt:starting_km',
            'income' => 'required|numeric',
            'petrol_poured' => 'required|numeric',
            'petrol_litres' => 'required|numeric',
            'logged_on' => 'required|date',
            'vehicle' => 'required|string',
            'driver_id' => 'required|integer',
            'driver_name' => 'required|string',
            'expense_detail' => 'nullable|string',
            'expense_price' => 'nullable|numeric',
        ]);

        $vehicleIncome->update($validatedData);

        return redirect()->route('admin.vehicle-incomes.index')->with('success', 'Vehicle Income updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleIncome $vehicleIncome)
    {
        $vehicleIncome->delete();
        return redirect()->route('admin.vehicle-incomes.index')->with('success', 'Vehicle Income deleted successfully.');
    }

    public function exportPdf()
    {
        $vehicleIncomes = VehicleIncome::all();
        $pdf = Pdf::loadView('admin.vehicle-incomes.pdf', compact('vehicleIncomes'));
        return $pdf->download('vehicle_incomes.pdf');
    }

    public function exportWord()
    {
        $vehicleIncomes = VehicleIncome::all();
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        
        $section->addText('Vehicle Incomes');
        
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000)->addText('Date');
        $table->addCell(2000)->addText('Vehicle');
        $table->addCell(2000)->addText('Driver');
        $table->addCell(2000)->addText('Income');
        
        foreach ($vehicleIncomes as $income) {
            $table->addRow();
            $table->addCell(2000)->addText($income->logged_on->format('Y-m-d'));
            $table->addCell(2000)->addText($income->vehicle);
            $table->addCell(2000)->addText($income->driver_name);
            $table->addCell(2000)->addText(number_format($income->income, 2));
        }
        
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $filename = 'vehicle_incomes.docx';
        $writer->save(storage_path($filename));
        
        return response()->download(storage_path($filename))->deleteFileAfterSend();
    }
}
