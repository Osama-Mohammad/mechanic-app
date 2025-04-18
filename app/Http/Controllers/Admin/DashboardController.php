<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\ServiceRequest;
use App\Models\EmergencyRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalCustomers = Customer::count();
        $totalMechanics = Mechanic::count();
        $activeServiceRequests = ServiceRequest::where('status', '!=', 'completed')->count();
        $pendingEmergencyRequests = EmergencyRequest::where('status', 'pending')->count();

        // Get service requests chart data
        $serviceRequestsChart = $this->getServiceRequestsChartData();

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        // Get recent service requests
        $recentServiceRequests = ServiceRequest::with(['customer', 'serviceType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalMechanics',
            'activeServiceRequests',
            'pendingEmergencyRequests',
            'serviceRequestsChart',
            'recentActivities',
            'recentServiceRequests'
        ));
    }

    private function getServiceRequestsChartData()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $requests = ServiceRequest::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $formattedDate = $date->format('M d');
            $labels[] = $formattedDate;

            $request = $requests->firstWhere('date', $date->format('Y-m-d'));
            $data[] = $request ? $request->count : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Get recent service requests
        $recentServiceRequests = ServiceRequest::with('customer')
            ->latest()
            ->take(3)
            ->get();

        foreach ($recentServiceRequests as $request) {
            $activities[] = [
                'type' => 'primary',
                'message' => "New service request from {$request->customer->name}",
                'time' => $request->created_at->diffForHumans()
            ];
        }

        // Get recent emergency requests
        $recentEmergencyRequests = EmergencyRequest::with('customer')
            ->latest()
            ->take(2)
            ->get();

        foreach ($recentEmergencyRequests as $request) {
            $activities[] = [
                'type' => 'warning',
                'message' => "Emergency request from {$request->customer->name}",
                'time' => $request->created_at->diffForHumans()
            ];
        }

        // Sort activities by time
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }
} 