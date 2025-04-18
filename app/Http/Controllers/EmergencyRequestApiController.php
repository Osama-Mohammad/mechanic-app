<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyRequest;

class EmergencyRequestApiController extends Controller
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
            'description' => 'required|min:2',
            'mechanics' => 'required',
            'responseTime' => 'required',
        ]);

        if (!$validated['mechanics']) {
            return response()->json([
                'error' => 'Please select a mechanic.',
            ], 400);
        }

        // Convert the date format from 'm/d/Y' to 'Y-m-d' so mySQL can understand it
        $response_time = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['responseTime'])->format('Y-m-d');


        $emergencyRequest = new EmergencyRequest();
        $emergencyRequest->description = $validated['description'];
        $emergencyRequest->location = $request->user()->location;
        $emergencyRequest->status = 'pending';
        $emergencyRequest->response_time = $response_time;
        $emergencyRequest->customer_id = $request->user()->id;
        $emergencyRequest->mechanic_id = $validated['mechanics'];

        $emergencyRequest->save();

        return response()->json([
            'message' => 'Emergency request created successfully.',
            'emergencyRequest' => $emergencyRequest,
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
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }
        $emergencyRequest = EmergencyRequest::findOrFail($id);
        if (!$emergencyRequest) {
            return response()->json([
                'error' => 'Emergency request not found',
            ], 404);
        }
        if ($request->user()->id != $emergencyRequest->mechanic_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }
        $validated = $request->validate([
            'status' => 'required|in:pending,inprogress,completed,canceled,paid',
        ]);
        $emergencyRequest->status = $validated['status'];
        $emergencyRequest->save();
        return response()->json([
            'message' => 'Emergency request updated successfully',
            'emergency_request' => $emergencyRequest,
            'user' => $request->user(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $emergencyRequest = EmergencyRequest::findOrFail($id);

        if (!$emergencyRequest) {
            return response()->json([
                'error' => 'Emergency request not found',
            ], 404);
        }

        if ($request->user()->id != $emergencyRequest->mechanic_id || $request->user()->id != $emergencyRequest->customer_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $emergencyRequest->delete();

        return response()->json([
            'message' => 'Emergency Request deleted successfully',
            'emergencyRequest' => $emergencyRequest,
        ], 200);
    }

    public function accept(Request $request, string $id)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $emergencyRequest = EmergencyRequest::findOrFail($id);

        if (!$emergencyRequest) {
            return response()->json([
                'error' => 'Emergency request not found',
            ], 404);
        }

        if ($request->user()->id != $emergencyRequest->mechanic_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $emergencyRequest->status = 'inprogress';

        $emergencyRequest->save();

        return response()->json([
            'message' => 'Emergency request accepted successfully',
            'emergency_request' => $emergencyRequest,
        ], 200);
    }

    public function decline(Request $request, string $id)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $emergencyRequest = EmergencyRequest::findOrFail($id);

        if (!$emergencyRequest) {
            return response()->json([
                'error' => 'Emergency request not found',
            ], 404);
        }
        if ($request->user()->id != $emergencyRequest->mechanic_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $emergencyRequest->status = 'canceled';

        $emergencyRequest->save();

        return response()->json([
            'message' => 'Emergency request declined successfully',
            'emergency_request' => $emergencyRequest,
        ], 200);
    }
}
