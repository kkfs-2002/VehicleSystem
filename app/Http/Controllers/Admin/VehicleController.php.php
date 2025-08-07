<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
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

    public function approve($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->status = 'approved';
        $vehicle->save();

        Session::flash('success', 'Vehicle approved successfully.');
        return redirect()->back();
    }

    public function reject($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->status = 'rejected';
        $vehicle->save();

        Session::flash('error', 'Vehicle rejected.');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        // Delete the image
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }
        
        $vehicle->delete();

        Session::flash('success', 'Vehicle deleted successfully.');
        return redirect()->back();
    }
}