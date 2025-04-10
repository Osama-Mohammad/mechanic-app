<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

class ServiceTypeController extends Controller
{

    public function index()
    {
        $serviceTypes = ServiceType::where('mechanic_id', Auth::guard('mechanic')->user()->id)->get();
        return view('ServiceType.index', compact('serviceTypes'));
    }


    public function create()
    {
        return view('ServiceType.create');
    }

    public function store(Request $request)
    {
        $validated =  $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $validated['mechanic_id'] = Auth::guard('mechanic')->user()->id;

        $serviceType = new ServiceType();
        $serviceType->name = $validated['name'];
        $serviceType->price = $validated['price'];
        $serviceType->mechanic_id = $validated['mechanic_id'];
        $serviceType->save();

        return redirect()->route('mechanic.service-type.index')->with('success', 'Service Type created successfully.');
    }

    public function ChangeServiceType(Request $request)
    {
        $ServiceTypes = ServiceType::where('mechanic_id', $request->id)->get();
        return response()->json(['ServiceTypes' => $ServiceTypes]);
    }

    public function edit($id)
    {
        $serviceType = ServiceType::findOrFail($id);
        return view('ServiceType.edit', compact('serviceType'));
    }
    public function update(Request $request, $id)
    {
        $validated =  $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $serviceType = ServiceType::findOrFail($id);
        $serviceType->name = $validated['name'];
        $serviceType->price = $validated['price'];
        $serviceType->save();

        return redirect()->route('mechanic.service-type.index')->with('success', 'Service Type updated successfully.');
    }
    public function destroy(Request $request)
    {
        $serviceType = ServiceType::findOrFail($request->id);
        $serviceType->delete();

        return response()->json(['id' => $request->id, 'msg' => 'Deleted Service Type Successfully']);
    }
}
