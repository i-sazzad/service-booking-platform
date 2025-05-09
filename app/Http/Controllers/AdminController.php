<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ===== SERVICES =====
    public function listServices()
    {
        return response()->json(Service::paginate(10));
    }

    public function createService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $service = Service::create($validated);

        return response()->json(['message' => 'Service created successfully', 'service' => $service], 201);
    }

    public function getService($id)
    {
        $service = Service::find($id);

        return $service
            ? response()->json($service)
            : response()->json(['error' => 'Service not found'], 404);
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) return response()->json(['error' => 'Service not found'], 404);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        // Only update fields that were passed in the request
        $service->update(array_filter($validated));  // array_filter to avoid updating null values

        return response()->json(['message' => 'Service updated successfully', 'service' => $service]);
    }

    public function deleteService($id)
    {
        $service = Service::find($id);
        if (!$service) return response()->json(['error' => 'Service not found'], 404);

        $service->delete();
        return response()->json(['message' => 'Service deleted successfully']);
    }

    // ===== BOOKINGS =====
    public function listBookings()
    {
        $bookings = Booking::with('service')->orderBy('created_at', 'desc')->paginate(10);

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found'], 404);
        }

        return response()->json($bookings);
    }
}
