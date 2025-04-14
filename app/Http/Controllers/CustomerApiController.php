<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'message' => 'Customers retrieved successfully',
            'customers' => $customers,
            'status' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:customers,phone|max:15',
            'location' => 'required|string|max:255',
            'email' => 'required|unique:customers,email|unique:mechanics,email|unique:admins,email|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ],
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $customer = new Customer();
        $customer->name = $validated['name'];
        $customer->phone = $validated['phone'];
        $customer->location = $validated['location'];
        $customer->latitude = $validated['latitude'] ?? null;
        $customer->longitude = $validated['longitude'] ?? null;
        $customer->email = $validated['email'];
        $customer->password = bcrypt($validated['password']);
        $customer->registration_date = now();
        $customer->save();

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer,
            'status' => 201
        ]);
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

        $customer = Customer::find($request->user()->id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:customers,phone,' . $customer->id,
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'email' => 'required|email|unique:customers,email,' . $customer->id  . '|unique:mechanics,email|unique:admins,email',
        ]);

        if ($validated) {
            $customer = Customer::find($request->user()->id);
            $customer->update($validated);
            return response()->json([
                'message' => 'Customer updated successfully',
                'customer' => $customer,
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Validation failed',
                'status' => 400
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
