<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\EmergencyRequest;
use App\Models\Mechanic;
use App\Models\ServiceRequest;
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

        $customer = Auth::guard('customer')->user();


        // Get the nearest mechanics using the Haversine formula
        $mechanics = Mechanic::selectRaw(
            "*, (6371 * acos(
                cos(radians(?)) * cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(latitude))
            )) AS distance",
            [$customer->latitude, $customer->longitude, $customer->latitude]
        )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('availability', 'Available')
            ->having('distance', '<', 50)  // Only within 50 km
            ->orderBy('distance')
            ->limit(10)  // Get only the top 10 nearest mechanics
            ->get();

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

        return redirect()->route('emergency.request.create')->with('success', 'created successfully');
    }

    public function MechanicRequest(Mechanic $mechanic)
    {
        $requests = $mechanic->emergencyRequests;
        $RegularRequests = ServiceRequest::where('mechanic_id', $mechanic->id)->with('customer')->get();
        return view('EmergencyRequest.MechanicRequests', compact('mechanic', 'requests', 'RegularRequests'));
    }

    public function MechanicUpdateRequestEmergency(Request $request)
    {
        $report = EmergencyRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->update(['status' => $request->status]);

        return response()->json(['msg' => 'Updated successfully', 'report' => $report]);
    }

    public function MechanicDeleteRequestEmergency(Request $request)
    {
        $report = EmergencyRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->delete();

        return response()->json(['msg' => 'Deleted Request Successfully', 'id' => $request->id]);
    }


    public function MechanicAcceptRequestEmergency(Request $request)
    {
        $report = EmergencyRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->update(['status' => 'inprogress']);

        return response()->json(['msg' => 'Accepted Request Successfully', 'id' => $request->id]);
    }

    public function MechanicRejectRequestEmergency(Request $request)
    {
        $report = EmergencyRequest::find($request->id);

        if (!$report) {
            return response()->json(['msg' => 'Request not found'], 404);
        }

        $report->update(['status' => 'canceled']);

        return response()->json(['msg' => 'Rejected Request Successfully', 'id' => $request->id]);
    }
}
