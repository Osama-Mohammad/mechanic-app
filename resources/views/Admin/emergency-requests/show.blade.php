@extends('admin.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>Emergency Request Details
            </h3>
            <a href="{{ route('admin.emergency-requests.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <!-- Emergency Request Details -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Request Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $emergencyRequest->id }}</td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $emergencyRequest->description }}</td>
                                </tr>
                                <tr>
                                    <th>Location:</th>
                                    <td>{{ $emergencyRequest->location }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $emergencyRequest->status == 'completed' ? 'success' : 
                                            ($emergencyRequest->status == 'canceled' ? 'danger' : 
                                            ($emergencyRequest->status == 'inprogress' ? 'primary' : 
                                            ($emergencyRequest->status == 'accepted' ? 'info' : 'warning'))) }}">
                                            {{ ucfirst($emergencyRequest->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Response Time:</th>
                                    <td>
                                        @if(!$emergencyRequest->response_time)
                                            N/A
                                        @elseif($emergencyRequest->response_time instanceof \Carbon\Carbon)
                                            {{ $emergencyRequest->response_time->format('M d, Y H:i') }}
                                        @else
                                            {{ $emergencyRequest->response_time }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $emergencyRequest->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $emergencyRequest->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $emergencyRequest->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $emergencyRequest->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $emergencyRequest->customer->phone ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Mechanic Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Mechanic Information</h5>
                        </div>
                        <div class="card-body">
                            @if($emergencyRequest->mechanic)
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $emergencyRequest->mechanic->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $emergencyRequest->mechanic->email }}</td>
                                    </tr>
                                </table>
                            @else
                                <div class="alert alert-info">No mechanic assigned yet</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Request Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.emergency-requests.update', $emergencyRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="pending" {{ $emergencyRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $emergencyRequest->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="inprogress" {{ $emergencyRequest->status == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $emergencyRequest->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="canceled" {{ $emergencyRequest->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ $emergencyRequest->notes ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 