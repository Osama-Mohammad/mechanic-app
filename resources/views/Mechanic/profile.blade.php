<x-layout>
    <x-nav />
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-center">
                            <i class="fas fa-user"></i> Mechanic Profile
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <p class="form-control bg-dark text-light">{{ $mechanic->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <p class="form-control bg-dark text-light">+961 {{ $mechanic->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <p class="form-control bg-dark text-light">{{ $mechanic->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Experience:</label>
                            <p class="form-control bg-dark text-light">{{ $mechanic->experience }} Year(s)</p>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Availability:</label>
                            <p class="form-control bg-dark text-light">{{ $mechanic->availability }}</p>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('mechanic.profile.edit', $mechanic) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
