<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Add this line

class VehicleController extends Controller
{
    // Show all approved vehicles to customers
   public function index()
{
    $approvedVehicles = Vehicle::where('approved', true)->get();
    $pendingVehicles = collect();

    if (Auth::check()) {
        $pendingVehicles = Vehicle::where('approved', false)
            ->where('user_id', Auth::id())
            ->get();
    }

    return view('vehicles.index', compact('approvedVehicles', 'pendingVehicles'));
}
    // Show form for admin to create vehicle
    public function create()
    {
        return view('vehicles.create');
    }

    // Store vehicle from admin
    public function store(Request $request)
{
    // Add detailed validation
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        'price' => 'required|numeric|min:0',
        'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'fuel' => 'required|in:petrol,diesel,electric,hybrid',
        'transmission' => 'required|in:automatic,manual,semi-automatic',
        'mileage' => 'nullable|integer|min:0',
        'color' => 'nullable|string|max:50',
        'seats' => 'nullable|integer|min:1|max:20',
        'details' => 'nullable|string'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        // Handle file upload
        $imagePath = $request->file('image')->store('vehicles', 'public');

        // Create vehicle record
        $vehicle = Vehicle::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'image' => $imagePath,
            'price' => $request->price,
            'year' => $request->year,
            'brand' => $request->brand,
            'model' => $request->model,
            'mileage' => $request->mileage ?? 0,
            'color' => $request->color,
            'fuel' => $request->fuel,
            'transmission' => $request->transmission,
            'seats' => $request->seats,
            'details' => $request->details,
               'approved' => 0, // Auto-approve for admins
        ]);

        return response()->json([
            'status' => 'success',
            'message' => Auth::user()->is_admin 
                ? 'Vehicle added successfully.' 
                : 'Vehicle added, pending approval.',
            'vehicle' => $vehicle
        ]);

    } catch (\Exception $e) {
        \Log::error('Vehicle store error: '.$e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Server error: '.$e->getMessage()
        ], 500);
    }
}
    // Reject (delete) vehicle
    public function reject(Request $request)
    {
        try {
            $vehicle = Vehicle::findOrFail($request->id);
            
            // Delete the image
            Storage::disk('public')->delete($vehicle->image);
            
            $vehicle->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle rejected and deleted.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reject vehicle: ' . $e->getMessage()
            ], 500);
        }

    }

public function approve($id)
{
    try {
        $vehicle = Vehicle::findOrFail($id);
        
        // Check if already approved
        if ($vehicle->status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle is already approved'
            ]);
        }
        
        $vehicle->status = 'approved';
        $vehicle->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Vehicle approved successfully'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error approving vehicle: ' . $e->getMessage()
        ], 500);
    }
}
public function destroy(Request $request)
{
    try {
        $vehicle = Vehicle::findOrFail($request->id);

        // Delete vehicle image from storage
        Storage::disk('public')->delete($vehicle->image);

        $vehicle->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete vehicle: ' . $e->getMessage()
        ], 500);
    }
}


}