<x-layout>
    <x-nav />
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-center">
                            <i class="fas fa-user"></i> Admin Profile
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <p class="form-control bg-dark text-light">{{ $admin->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <p class="form-control bg-dark text-light">{{ $admin->email }}</p>
                        </div>


                        <div class="d-grid">
                            <a href="{{ route('admin_EditProfilePage', $admin) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
