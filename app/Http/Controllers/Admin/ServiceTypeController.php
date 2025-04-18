<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of service types.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceTypes = ServiceType::latest()->paginate(10);
        return view('admin.service-types.index', compact('serviceTypes'));
    }

    /**
     * Show the form for creating a new service type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service-types.create');
    }

    /**
     * Store a newly created service type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_types',
            'price' => 'required|numeric|min:0',
            'mechanic_id' => 'required|exists:mechanics,id',
        ]);
        
        ServiceType::create($validated);
        
        return redirect()->route('admin.service-types.index')
            ->with('success', 'Service type created successfully');
    }

    /**
     * Show the form for editing the specified service type.
     *
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceType $serviceType)
    {
        return view('admin.service-types.edit', compact('serviceType'));
    }

    /**
     * Update the specified service type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceType $serviceType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:service_types,name,' . $serviceType->id,
            'price' => 'required|numeric|min:0',
            'mechanic_id' => 'required|exists:mechanics,id',
        ]);
        
        $serviceType->update($validated);
        
        return redirect()->route('admin.service-types.index')
            ->with('success', 'Service type updated successfully');
    }

    /**
     * Remove the specified service type from storage.
     *
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceType $serviceType)
    {
        $serviceType->delete();
        
        return redirect()->route('admin.service-types.index')
            ->with('success', 'Service type deleted successfully');
    }
} 