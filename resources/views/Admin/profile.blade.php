<x-layout>
    <x-nav />
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-shield me-2"></i>Admin Profile
                        </h5>
                    </div>
                    <div class="card-body bg-dark text-white">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <p class="form-control bg-dark text-light">{{ $admin->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <p class="form-control bg-dark text-light">{{ $admin->email }}</p>
                        </div>


                        <div class="d-grid">
                            <a href="{{ route('admin.profile.edit', $admin) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
