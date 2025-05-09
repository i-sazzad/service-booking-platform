<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;

class CustomerController extends Controller
{
    // 1. List Services
    public function listServices(Request $request)
    {
        $services = Service::paginate(10);
        return response()->json($services, 200);
    }

    // 2. Book a Service
    public function bookService(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'nullable|date',  // Ensure it's a valid date
        ]);

        // Create the booking
        $booking = Booking::create([
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'service_id' => $validated['service_id'],
            'scheduled_at' => $validated['scheduled_at'],
            'status' => 'Pending', // Default status, you can update this if needed
        ]);

        return response()->json([
            'message' => 'Service booked successfully',
            'booking_id' => $booking->id,
            'status' => $booking->status
        ], 201);
    }

    // 3. Booking Status
public function bookingStatus($id)
{
    // Attempt to find the booking by ID with the related service
    $booking = Booking::with('service')->find($id);

    // If the booking is not found, return a 404 error
    if (!$booking) {
        return response()->json(['error' => 'Booking not found'], 404);
    }

    // Check if the service is available and handle null service gracefully
    $serviceName = $booking->service ? $booking->service->name : 'No service assigned';

    // Return the booking details with the service info
    return response()->json([
        'booking_id' => $booking->id,
        'customer_name' => $booking->customer_name,
        'status' => $booking->status,
        'service' => $serviceName,
        'scheduled_at' => $booking->scheduled_at,
    ], 200);
}

}
