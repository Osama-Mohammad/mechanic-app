<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mechanics = Mechanic::all();
        return response()->json($mechanics);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email|unique:mechanics,email|unique:mechanics,email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ],
            'phone' => 'required|string|unique:customers,phone|max:15',
            'specialization' => 'required|min:5',
            'experience' => 'required|numeric',
            'location' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
            'workdays' => 'required|array'
        ]);

        if ($validated) {
            $mechanic = new Mechanic();
            $mechanic->name = $request->name;
            $mechanic->email = $request->email;
            $mechanic->password = bcrypt($request->password);
            $mechanic->phone = $request->phone;
            $mechanic->specialization = $request->specialization;
            $mechanic->experience = $request->experience;
            $mechanic->location = $request->location;
            $mechanic->longitude = $request->longitude;
            $mechanic->latitude = $request->latitude;
            $mechanic->workdays = json_encode($request->workdays); // if stored as JSON

            // ✅ Add these two lines
            $validated['start_time'] = Carbon::createFromFormat('h:i:s A', $validated['start_time'])->format('H:i:s');
            $validated['end_time'] = Carbon::createFromFormat('H:i:s', $validated['end_time'])->format('H:i:s'); // already in 24-hour format

            $mechanic->start_time = $validated['start_time'];
            $mechanic->end_time = $validated['end_time'];

            $mechanic->save();
            return response()->json([
                'message' => 'Mechanic registered successfully',
                'mechanic' => $mechanic,
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
        $mechanic = Mechanic::findOrFail($request->user()->id);
        if (!$mechanic) {
            return response()->json(['message' => 'Mechanic not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|string|max:15|unique:customers,phone,' . $mechanic->id,
            'email' => 'required|email|unique:customers,email|unique:admins,email|unique:mechanics,email,' . $mechanic->id,
            'experience' => 'required|numeric',
            'availability' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'workdays' => 'required|array'
        ]);
        $validated['start_time'] = Carbon::createFromFormat('h:i:s A', $validated['start_time'])->format('H:i:s');
        $validated['end_time'] = Carbon::createFromFormat('H:i:s', $validated['end_time'])->format('H:i:s'); // already in 24-hour format

        if ($validated) {

            $mechanic->update($validated);
            return response()->json([
                'message' => 'Mechanic updated successfully',
                'mechanic' => $mechanic,
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
