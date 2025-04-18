@extends('admin.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fas fa-wrench me-2"></i>Service Request Details
            </h3>
            <a href="{{ route('admin.service-requests.index') }}" class="btn btn-sm btn-secondary">
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
                <!-- Service Request Details -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Request Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $serviceRequest->id }}</td>
                                </tr>
                                <tr>
                                    <th>Service Type:</th>
                                    <td>{{ $serviceRequest->serviceType->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $serviceRequest->status == 'completed' ? 'success' : 
                                            ($serviceRequest->status == 'canceled' ? 'danger' : 
                                            ($serviceRequest->status == 'inprogress' ? 'primary' : 
                                            ($serviceRequest->status == 'accepted' ? 'info' : 'warning'))) }}">
                                            {{ ucfirst($serviceRequest->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $serviceRequest->date }}</td>
                                </tr>
                                <tr>
                                    <th>Time:</th>
                                    <td>{{ $serviceRequest->time }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $serviceRequest->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $serviceRequest->updated_at->format('M d, Y H:i') }}</td>
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
                                    <td>{{ $serviceRequest->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $serviceRequest->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $serviceRequest->customer->phone ?? 'N/A' }}</td>
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
                            @if($serviceRequest->mechanic)
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $serviceRequest->mechanic->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $serviceRequest->mechanic->email }}</td>
                                    </tr>
                                </table>
                            @else
                                <div class="alert alert-info">No mechanic assigned yet</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payment Information</h5>
                </div>
                <div class="card-body">
                    @if($serviceRequest->payment)
                        <table class="table">
                            <tr>
                                <th>Amount:</th>
                                <td>${{ number_format($serviceRequest->payment->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $serviceRequest->payment->status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($serviceRequest->payment->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ $serviceRequest->payment->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    @else
                        <div class="alert alert-warning">No payment record found</div>
                    @endif
                </div>
            </div>

            <!-- Update Status Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Request Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.service-requests.update', $serviceRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="pending" {{ $serviceRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $serviceRequest->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="inprogress" {{ $serviceRequest->status == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $serviceRequest->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="canceled" {{ $serviceRequest->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                        <option value="paid" {{ $serviceRequest->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ $serviceRequest->notes }}</textarea>
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