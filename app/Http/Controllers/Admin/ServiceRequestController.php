<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the service requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceRequests = ServiceRequest::with(['customer', 'mechanic', 'serviceType'])
            ->latest()
            ->paginate(10);

        return view('admin.service-requests.index', compact('serviceRequests'));
    }

    /**
     * Display the specified service request.
     *
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['customer', 'mechanic', 'serviceType', 'payment']);

        return view('admin.service-requests.show', compact('serviceRequest'));
    }

    /**
     * Update the specified service request in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,inprogress,completed,canceled,paid',
            'mechanic_id' => 'sometimes|exists:mechanics,id',
            'notes' => 'sometimes|nullable|string'
        ]);

        $serviceRequest->update($validated);

        return redirect()->route('admin.service-requests.show', $serviceRequest)
            ->with('success', 'Service request updated successfully');
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        $serviceRequest->delete();
        return redirect()->route('admin.service-requests.index')->with('success', 'Deleted Service Request Successfully');
    }
}
