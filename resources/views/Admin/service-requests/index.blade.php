<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-wrench me-2"></i>Service Requests Management
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
                                <th>Service Type</th>
                                <th>Mechanic</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($serviceRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->customer->name }}</td>
                                    <td>{{ $request->serviceType->name }}</td>
                                    <td>{{ $request->mechanic ? $request->mechanic->name : 'Not Assigned' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $request->status == 'completed' ? 'success' : 
                                            ($request->status == 'canceled' ? 'danger' : 
                                            ($request->status == 'inprogress' ? 'primary' : 
                                            ($request->status == 'accepted' ? 'info' : 'warning'))) }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.service-requests.show', $request) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No service requests found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $serviceRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout> 