<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>Review Details
                </h3>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-secondary">
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
                    <!-- Review Details -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Review Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>ID:</th>
                                        <td>{{ $review->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rating:</th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">{{ $review->rating }}/5</span>
                                                <div class="text-warning">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Comment:</th>
                                        <td>{{ $review->comment }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ $review->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Customer and Mechanic Info -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $review->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $review->customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer ID:</th>
                                        <td>
                                            <a href="{{ route('admin.customers.show', $review->customer) }}">
                                                {{ $review->customer->id }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Mechanic Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $review->mechanic->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $review->mechanic->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mechanic ID:</th>
                                        <td>
                                            <a href="{{ route('admin.mechanics.show', $review->mechanic) }}">
                                                {{ $review->mechanic->id }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Service Request Info -->
                @if($review->serviceRequest)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Related Service Request</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Service Request ID:</th>
                                <td>
                                    <a href="{{ route('admin.service-requests.show', $review->serviceRequest) }}">
                                        {{ $review->serviceRequest->id }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Service Type:</th>
                                <td>{{ $review->serviceRequest->serviceType->name }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $review->serviceRequest->status == 'completed' ? 'success' : 
                                        ($review->serviceRequest->status == 'canceled' ? 'danger' : 
                                        ($review->serviceRequest->status == 'inprogress' ? 'primary' : 
                                        ($review->serviceRequest->status == 'accepted' ? 'info' : 'warning'))) }}">
                                        {{ ucfirst($review->serviceRequest->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ $review->serviceRequest->date }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout> 