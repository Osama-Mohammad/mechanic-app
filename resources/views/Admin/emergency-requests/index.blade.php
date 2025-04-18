<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Emergency Requests Management
                </h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Mechanic</th>
                                <th>Status</th>
                                <th>Response Time</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emergencyRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->customer->name }}</td>
                                    <td>{{ Str::limit($request->description, 30) }}</td>
                                    <td>{{ Str::limit($request->location, 30) }}</td>
                                    <td>{{ $request->mechanic ? $request->mechanic->name : 'Not Assigned' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $request->status == 'completed' ? 'success' : 
                                            ($request->status == 'canceled' ? 'danger' : 
                                            ($request->status == 'inprogress' ? 'primary' : 
                                            ($request->status == 'accepted' ? 'info' : 'warning'))) }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->response_time }}</td>
                                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.emergency-requests.show', $request) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No emergency requests found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $emergencyRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout> 