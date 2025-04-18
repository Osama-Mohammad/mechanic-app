<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-edit me-2"></i>Edit Service Type
                </h3>
                <a href="{{ route('admin.service-types.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.service-types.update', $serviceType) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Service Type Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $serviceType->name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $serviceType->price) }}" min="0" step="0.01" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mechanic_id" class="form-label">Assigned Mechanic</label>
                        <select class="form-select" id="mechanic_id" name="mechanic_id" required>
                            <option value="">Select a mechanic</option>
                            @foreach(\App\Models\Mechanic::orderBy('name')->get() as $mechanic)
                                <option value="{{ $mechanic->id }}" {{ old('mechanic_id', $serviceType->mechanic_id) == $mechanic->id ? 'selected' : '' }}>
                                    {{ $mechanic->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Please select a mechanic for this service type</small>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Service Type
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout> 