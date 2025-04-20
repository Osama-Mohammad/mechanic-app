<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Customer Details
                </h3>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row">
                    <!-- Customer Profile -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Profile</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>ID:</th>
                                        <td>{{ $customer->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td>{{ $customer->location ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Registered:</th>
                                        <td>{{ $customer->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                                <a href="{{ route('admin.customers.edit', $customer) }}">Edit</a>

                                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button>Delete</button>
                                </form>


                            </div>
                        </div>
                    </div>

                    <!-- Activity Summary -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Activity Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-6">
                                        <div class="p-3 border rounded text-center">
                                            <h3>{{ $customer->serviceRequests->count() }}</h3>
                                            <p class="mb-0">Service Requests</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border rounded text-center">
                                            <h3>{{ $customer->emergencyRequests->count() }}</h3>
                                            <p class="mb-0">Emergency Requests</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border rounded text-center">
                                            <h3>{{ $customer->reviews->count() }}</h3>
                                            <p class="mb-0">Reviews</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border rounded text-center">
                                            <h3>{{ $customer->payments->count() }}</h3>
                                            <p class="mb-0">Payments</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Requests Tab -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Service Requests</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Service Type</th>
                                        <th>Mechanic</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customer->serviceRequests as $request)
                                        <tr>
                                            <td>{{ $request->id }}</td>
                                            <td>{{ $request->serviceType->name }}</td>
                                            <td>{{ $request->mechanic ? $request->mechanic->name : 'Not Assigned' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $request->status == 'completed'
                                                        ? 'success'
                                                        : ($request->status == 'canceled'
                                                            ? 'danger'
                                                            : ($request->status == 'inprogress'
                                                                ? 'primary'
                                                                : ($request->status == 'accepted'
                                                                    ? 'info'
                                                                    : 'warning'))) }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.service-requests.show', $request) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No service requests found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Emergency Requests Tab -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Emergency Requests</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Location</th>
                                        <th>Mechanic</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customer->emergencyRequests as $request)
                                        <tr>
                                            <td>{{ $request->id }}</td>
                                            <td>{{ Str::limit($request->location, 30) }}</td>
                                            <td>{{ $request->mechanic ? $request->mechanic->name : 'Not Assigned' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $request->status == 'completed'
                                                        ? 'success'
                                                        : ($request->status == 'canceled'
                                                            ? 'danger'
                                                            : ($request->status == 'inprogress'
                                                                ? 'primary'
                                                                : ($request->status == 'accepted'
                                                                    ? 'info'
                                                                    : 'warning'))) }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.emergency-requests.show', $request) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No emergency requests found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
