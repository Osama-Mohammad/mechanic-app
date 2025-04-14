<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

class ServiceRequestApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $validated = $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'mechanic_id' => 'required',
            'time' => 'required',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $validated['customer_id'] = $request->user()->id;
        $mechanic = Mechanic::findOrFail($validated['mechanic_id']);

        $workdays = json_decode($mechanic->workdays, true);
        $selectedDay = Carbon::parse($validated['date'])->format('l'); // Get the day of the week (e.g., Monday)

        // Check if the selected date is within the mechanic's workdays
        if (!in_array($selectedDay, $workdays)) {
            return response()->json([
                'error' => 'The mechanic is not available on this date. Please choose another date.',
                'workdays' => $workdays,
                'start_time' => $mechanic->start_time,
                'end_time' => $mechanic->end_time,
                'selected_days' => $selectedDay,
            ], 400);
        }

        // Check if the selected time is within the mechanic's working hours
        if ($validated['time'] < $mechanic->start_time || $validated['time'] > $mechanic->end_time) {
            return response()->json([
                'error' => 'The selected time is outside the mechanic\'s working hours. Please choose another time.',
                'workdays' => $workdays,
                'start_time' => $mechanic->start_time,
                'end_time' => $mechanic->end_time,
                'selected_days' => $selectedDay,
            ], 400);
        }

        // Check for existing service requests at the same time
        $appointmentExists = ServiceRequest::where('mechanic_id', $validated['mechanic_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();


        if ($appointmentExists) {
            return response()->json([
                'reserved' => 'The mechanic is already booked at this time. Please choose another time.',
            ], 400);
        }

        // Convert the date format from 'm/d/Y' to 'Y-m-d' so mySQL can understand it
        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['date'])->format('Y-m-d');

        // Create the service request
        $serviceRequest = new ServiceRequest();
        $serviceRequest->service_type_id = $validated['service_type_id'];
        $serviceRequest->customer_id = $validated['customer_id'];
        $serviceRequest->mechanic_id = $validated['mechanic_id'];
        $serviceRequest->date = $date;
        $serviceRequest->time = Carbon::createFromFormat('h:i:s A', $validated['time'])->format('H:i:s');

        $serviceRequest->save();

        return response()->json([
            'message' => 'Service request created successfully',
            'service_request' => $serviceRequest,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
