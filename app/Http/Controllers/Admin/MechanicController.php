<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mechanic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MechanicController extends Controller
{
    /**
     * Display a listing of mechanics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mechanics = Mechanic::latest()->paginate(10);
        return view('admin.mechanics.index', compact('mechanics'));
    }

    /**
     * Display the specified mechanic.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function show(Mechanic $mechanic)
    {
        $mechanic->load(['serviceRequests', 'emergencyRequests', 'reviews']);
        return view('admin.mechanics.show', compact('mechanic'));
    }

    public function edit(Mechanic $mechanic)
    {
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];
        $selected_days = json_decode($mechanic->workdays, true);
        return view('Admin.mechanics.edit', compact('mechanic', 'selected_days', 'days'));
    }

    public function update(Request $request, Mechanic $mechanic)
    {

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
            'workdays' => 'required|array',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ]
        ]);

        if (isset($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $mechanic->update($validated);

        return redirect()->route('admin.mechanics.index', Auth::guard('admin')->user());
    }

    public function destroy(Mechanic $mechanic)
    {
        $mechanic->delete();
        return redirect()->route('admin.mechanics.index', Auth::guard('admin')->user());
    }
}
