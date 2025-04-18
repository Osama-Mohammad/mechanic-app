<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeApiController extends Controller
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        $validated['mechanic_id'] = $request->user()->id;
        $serviceType = new ServiceType();
        $serviceType->name = $validated['name'];
        $serviceType->price = $validated['price'];
        $serviceType->mechanic_id = $validated['mechanic_id'];
        $serviceType->save();

        return response()->json([
            'message' => 'Service Type created successfully.',
            'serviceType' => $serviceType,
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

        $serviceType = ServiceType::findOrFail($id);

        if (!$serviceType) {
            return response()->json([
                'error' => 'Service Type not found',
            ], 404);
        }

        if ($request->user()->id != $serviceType->mechanic_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        $serviceType->name = $validated['name'];
        $serviceType->price = $validated['price'];
        $serviceType->save();
        return response()->json([
            'message' => 'Service Type updated successfully.',
            'serviceType' => $serviceType,
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

        $serviceType = ServiceType::findOrFail($id);

        if (!$serviceType) {
            return response()->json([
                'error' => 'Service Type not found',
            ], 404);
        }

        if ($request->user()->id != $serviceType->mechanic_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $serviceType->delete();

        return response()->json([
            'message' => 'Service Type deleted successfully.',
            'serviceType' => $serviceType,
        ], 200);
    }
}
