<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Here you can add logic to fetch data for the dashboard
        return view('admin.dashboard');
    }
}
