<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DriverSalaryController extends Controller
{
    public function index()
    {
        $drivers = User::all(); // Fetch all users since they're all drivers
        return view('admin.driver-salaries.index', compact('drivers'));
    }

    public function update(Request $request, User $driver)
    {
        $request->validate([
            'salary' => 'required|numeric|min:0',
        ]);

        $driver->update(['salary' => $request->salary]);

        return redirect()->route('admin.driver-salaries.index')->with('success', 'Driver salary updated successfully.');
    }
}
