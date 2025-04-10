<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mechanic;
use App\Models\ServiceType;
use App\Models\ServiceRequest;
use App\Models\Customer;

class ServiceTypeController extends Controller
{
    public function create()
    {
        return view('ServiceType.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ServiceType::create([
            'name' => $request->name,
        ]);

        return redirect()->route('service-type.create')->with('success', 'Service Type created successfully.');
    }
}
