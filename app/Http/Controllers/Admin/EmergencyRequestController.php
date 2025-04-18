<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyRequest;
use Illuminate\Http\Request;

class EmergencyRequestController extends Controller
{
    /**
     * Display a listing of emergency requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emergencyRequests = EmergencyRequest::with(['customer', 'mechanic'])
            ->latest()
            ->paginate(10);
            
        return view('admin.emergency-requests.index', compact('emergencyRequests'));
    }

    /**
     * Display the specified emergency request.
     *
     * @param  \App\Models\EmergencyRequest  $emergencyRequest
     * @return \Illuminate\Http\Response
     */
    public function show(EmergencyRequest $emergencyRequest)
    {
        $emergencyRequest->load(['customer', 'mechanic']);
        
        return view('admin.emergency-requests.show', compact('emergencyRequest'));
    }

    /**
     * Update the specified emergency request in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmergencyRequest  $emergencyRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmergencyRequest $emergencyRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,inprogress,completed,canceled',
            'mechanic_id' => 'sometimes|exists:mechanics,id',
            'notes' => 'sometimes|nullable|string'
        ]);
        
        $emergencyRequest->update($validated);
        
        return redirect()->route('admin.emergency-requests.show', $emergencyRequest)
            ->with('success', 'Emergency request updated successfully');
    }
} 