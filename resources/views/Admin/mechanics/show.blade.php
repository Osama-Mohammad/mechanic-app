<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user-wrench me-2"></i>Mechanic Details
                </h3>
                <a href="{{ route('admin.mechanics.index') }}" class="btn btn-sm btn-secondary">
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
                    <!-- Mechanic Profile -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Mechanic Profile</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>ID:</th>
                                        <td>{{ $mechanic->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $mechanic->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $mechanic->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $mechanic->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Specialization:</th>
                                        <td>{{ $mechanic->specialization ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Experience:</th>
                                        <td>{{ $mechanic->experience ?? 'N/A' }} years</td>
                                    </tr>
                                    <tr>
                                        <th>Availability:</th>
                                        <td>{{ $mechanic->availability ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td>{{ $mechanic->location ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Working Hours:</th>
                                        <td>{{ $mechanic->start_time ?? '09:00' }} -
                                            {{ $mechanic->end_time ?? '17:00' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rating:</th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="me-2">{{ number_format($mechanic->average_rating, 1) }}</span>
                                                <div class="text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $mechanic->average_rating)
                                                            <i class="fas fa-star"></i>
                                                        @elseif($i <= $mechanic->average_rating + 0.5)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.mechanics.edit', $mechanic) }}"
                                        class="btn btn-warning">Edit</a>

                                    <form action="{{ route('admin.mechanics.destroy', $mechanic) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
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
                                        <h3>{{ $mechanic->serviceRequests->count() }}</h3>
                                        <p class="mb-0">Service Requests</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded text-center">
                                        <h3>{{ $mechanic->emergencyRequests->count() }}</h3>
                                        <p class="mb-0">Emergency Requests</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded text-center">
                                        <h3>{{ $mechanic->reviews->count() }}</h3>
                                        <p class="mb-0">Reviews</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded text-center">
                                        <h3>{{ $mechanic->serviceTypes->count() }}</h3>
                                        <p class="mb-0">Service Types</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Types -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Service Types</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mechanic->serviceTypes as $serviceType)
                                    <tr>
                                        <td>{{ $serviceType->id }}</td>
                                        <td>{{ $serviceType->name }}</td>
                                        <td>${{ number_format($serviceType->price, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No service types found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                                    <th>Customer</th>
                                    <th>Service Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mechanic->serviceRequests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>{{ $request->customer->name }}</td>
                                        <td>{{ $request->serviceType->name }}</td>
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
                                    <th>Customer</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mechanic->emergencyRequests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>{{ $request->customer->name }}</td>
                                        <td>{{ Str::limit($request->location, 30) }}</td>
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
