<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ServiceRequestDeclined;

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
    // public function create()
    // {
    //     $ServiceTypes = ServiceType::all();
    //     $customer = Auth::guard('customer')->user();
    //     $mechanics = Mechanic::where('location', Auth::guard('customer')->user()->location)
    //         ->withAvg('reviews as average_rating', 'rating')
    //         ->orderByDesc('average_rating')->get();
    //     return view('ServiceRequest.create', compact('mechanics', 'ServiceTypes'));
    // }

    public function create()
    {
        $customer = Auth::guard('customer')->user();

        // Get all service types
        $ServiceTypes = ServiceType::all();

        // Get the nearest mechanics using the Haversine formula
        $mechanics = Mechanic::selectRaw(
            "*, (6371 * acos(
                cos(radians(?)) * cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(latitude))
            )) AS distance",
            [$customer->latitude, $customer->longitude, $customer->latitude]
        )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('availability', 'Available')
            ->having('distance', '<', 50)  // Only within 50 km
            ->orderBy('distance')
            ->limit(10)  // Get only the top 10 nearest mechanics
            ->get();

        return view('ServiceRequest.create', compact('mechanics', 'ServiceTypes'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type_id' => 'required',
            'mechanic_id' => 'required',
            'time' => 'required',
            'date' => 'required',
        ]);

        $validated['customer_id'] = Auth::guard('customer')->user()->id;

        $workdays = json_decode(Mechanic::findOrFail($validated['mechanic_id'])->workdays, true);

        if (!in_array(Carbon::parse($validated['date'])->format('l'), $workdays)) {
            return back()->with('reserved', 'The mechanic is not available on this date. Please choose another date.');
        }

        // Correctly check for existing service requests
        $appointmentExists = ServiceRequest::where('mechanic_id', $validated['mechanic_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($appointmentExists) {
            return back()->with('reserved', 'The mechanic is already booked at this time. Please choose another date.');
        }

        $serviceRequest = new ServiceRequest();
        $serviceRequest->service_type_id = $validated['service_type_id'];
        $serviceRequest->customer_id = $validated['customer_id'];
        $serviceRequest->mechanic_id = $validated['mechanic_id'];
        $serviceRequest->date = $validated['date'];
        $serviceRequest->time = $validated['time'];

        $serviceRequest->save();

        return back()->with('success', 'Service request created successfully.');
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



    public function MechanicUpdateRequestRegular(Request $request)
    {
        $report = ServiceRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->update(['status' => $request->status]);

        return response()->json(['msg' => 'Updated successfully', 'report' => $report]);
    }

    public function MechanicDeleteRequestRegular(Request $request)
    {
        $report = ServiceRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->delete();

        return response()->json(['msg' => 'Deleted Request Successfully', 'id' => $request->id]);
    }


    public function MechanicAcceptRequestRegular(Request $request)
    {
        $serviceRequest = ServiceRequest::with('serviceType', 'customer')->findOrFail($request->id);

        if ($serviceRequest->status !== 'pending') {
            return response()->json(['msg' => 'Request is not in a pending state.'], 400);
        }

        $serviceRequest->update(['status' => 'inprogress']);

        return response()->json([
            'msg' => 'Request accepted successfully.',
            'request' => $serviceRequest,
        ]);
    }

    public function MechanicRejectRequestRegular(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:service_requests,id',
        ]);

        $report = ServiceRequest::findOrFail($request->id);
        $report->status = 'canceled';
        $report->save();


        $customer = $report->customer;
        $mechanic = $report->mechanic;

        if ($customer) {
            $customer->notify(new ServiceRequestDeclined($mechanic->name, $report->date, $report->time));
        }
        return response()->json(['msg' => 'Rejected Request Successfully', 'id' => $request->id, 'request' => $report]);
    }
}
