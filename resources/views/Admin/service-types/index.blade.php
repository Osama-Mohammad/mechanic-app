<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-list me-2"></i>Service Types Management
                </h3>
                <a href="{{ route('admin.service-types.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> Add Service Type
                </a>
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
                                <th>Name</th>
                                <th>Price</th>
                                <th>Mechanic</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($serviceTypes as $serviceType)
                                <tr>
                                    <td>{{ $serviceType->id }}</td>
                                    <td>{{ $serviceType->name }}</td>
                                    <td>${{ number_format($serviceType->price, 2) }}</td>
                                    <td>{{ $serviceType->mechanic ? $serviceType->mechanic->name : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.service-types.edit', $serviceType) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.service-types.destroy', $serviceType) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this service type?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No service types found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $serviceTypes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout> 