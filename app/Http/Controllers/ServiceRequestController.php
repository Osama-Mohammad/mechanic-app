<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceRequests = ServiceRequest::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('serviceType')->get();
        return view('ServiceRequest.index', compact('serviceRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ServiceTypes = ServiceType::all();
        $mechanics = Mechanic::where('location', Auth::guard('customer')->user()->location)
            ->withAvg('reviews as average_rating', 'rating')
            ->orderByDesc('average_rating')->get();
        return view('ServiceRequest.create', compact('mechanics', 'ServiceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type_id' => 'required',
            'appointment_time' => 'required',
            'mechanic_id' => 'required',
            // 'status' => 'required'
        ]);
        $validated['customer_id'] = Auth::guard('customer')->user()->id;

        $appointmentExists = ServiceRequest::where('mechanic_id', $validated['mechanic_id'])
            ->where('appointment_time', '=', date('y-m-d', strtotime($validated['appointment_time'])))
            ->exists();

        if ($appointmentExists) {
            return back()->with('reserved', 'The mechanic is already booked at this time. Please choose another date.');
        }

        $serviceRequest = new ServiceRequest();
        $serviceRequest->service_type_id = $validated['service_type_id'];
        // $serviceRequest->status = $validated['status'];
        $serviceRequest->appointment_time = $validated['appointment_time'];
        $serviceRequest->customer_id = $validated['customer_id'];
        $serviceRequest->mechanic_id = $validated['mechanic_id'];

        $serviceRequest->save();
        return back()->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        //
    }
}
