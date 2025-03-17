<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\EmergencyRequest;
use App\Models\Mechanic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class EmergencyRequestController extends Controller
{
    public function index()
    {
        $cities = [
            "Beirut",
            "Tripoli",
            "Sidon",
            "Tyre",
            "Zahle",
            "Jounieh",
            "Baalbek",
            "Byblos",
            "Batroun",
            "Nabatieh",
            "Bcharré",
            "Keserwan",
            "Chouf",
            "Marjeyoun",
            "Aley",
            "Metn",
            "Baabda",
            "Hermel",
            "Rashaya",
            "Jbeil"
        ];
        $mechanics = Mechanic::where('location', Auth::guard('customer')->user()->location)->get();
        return view('EmergencyRequest.create', compact('cities', 'mechanics'));
    }

    public function store(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'description' => 'required|min:2',
            'mechanics' => 'required',
            'responseTime' => 'required',
        ]);

        $request = new EmergencyRequest();
        $request->description = $validated['description'];
        $request->location = $customer->location;
        $request->status = 'pending';
        $request->response_time = $validated['responseTime'];
        $request->customer_id = $customer->id;
        $request->mechanic_id = $validated['mechanics'];

        $request->save();

        return redirect('/');
    }

    public function MechanicRequest(Mechanic $mechanic)
    {
        $requests = $mechanic->emergencyRequests;
        return view('EmergencyRequest.MechanicRequests', compact('mechanic', 'requests'));
    }

    public function MechanicUpdateRequest(Request $request)
    {
        $report = EmergencyRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->update(['status' => $request->status]);

        return response()->json(['msg' => 'Updated successfully', 'report' => $report]);
    }

    public function MechanicDeleteRequest(Request $request)
    {
        $report = EmergencyRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->delete();

        return response()->json(['msg' => 'Deleted Request Successfully', 'id' => $request->id]);
    }
}
