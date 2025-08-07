<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $vehicles = Vehicle::with('user')->latest()->paginate(10);
        
        $totalVehicles = Vehicle::count();
        $approvedVehicles = Vehicle::where('status', 'approved')->count();
        $pendingVehicles = Vehicle::where('status', 'pending')->count();
        $rejectedVehicles = Vehicle::where('status', 'rejected')->count();

        return view('admin.dashboard', compact(
            'vehicles',
            'totalVehicles',
            'approvedVehicles',
            'pendingVehicles',
            'rejectedVehicles'
        ));
    }
}