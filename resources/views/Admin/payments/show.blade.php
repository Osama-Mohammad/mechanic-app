<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-credit-card me-2"></i>Payment Details
                </h3>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary">
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
                    <!-- Payment Details -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Payment Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>ID:</th>
                                        <td>{{ $payment->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Amount:</th>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Method:</th>
                                        <td>{{ $payment->method }}</td>
                                    </tr>
                                    @if($payment->reference_id)
                                    <tr>
                                        <th>Reference ID:</th>
                                        <td>{{ $payment->reference_id }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Transaction Date:</th>
                                        <td>{{ $payment->transaction_date ? $payment->transaction_date->format('M d, Y H:i') : $payment->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $payment->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $payment->customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $payment->customer->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer ID:</th>
                                        <td>
                                            <a href="{{ route('admin.customers.show', $payment->customer) }}">
                                                {{ $payment->customer->id }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Service Request Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Related Service Request</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Service Request ID:</th>
                                <td>
                                    <a href="{{ route('admin.service-requests.show', $payment->serviceRequest) }}">
                                        {{ $payment->serviceRequest->id }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Service Type:</th>
                                <td>{{ $payment->serviceRequest->serviceType->name }}</td>
                            </tr>
                            <tr>
                                <th>Mechanic:</th>
                                <td>
                                    @if($payment->serviceRequest->mechanic)
                                        <a href="{{ route('admin.mechanics.show', $payment->serviceRequest->mechanic) }}">
                                            {{ $payment->serviceRequest->mechanic->name }}
                                        </a>
                                    @else
                                        Not Assigned
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $payment->serviceRequest->status == 'completed' ? 'success' : 
                                        ($payment->serviceRequest->status == 'canceled' ? 'danger' : 
                                        ($payment->serviceRequest->status == 'inprogress' ? 'primary' : 
                                        ($payment->serviceRequest->status == 'accepted' ? 'info' : 'warning'))) }}">
                                        {{ ucfirst($payment->serviceRequest->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ $payment->serviceRequest->date }}</td>
                            </tr>
                            <tr>
                                <th>Time:</th>
                                <td>{{ $payment->serviceRequest->time }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout> 