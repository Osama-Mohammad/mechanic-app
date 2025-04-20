<body class="bg-dark text-light">
    <x-layout>
        <x-nav />
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header bg-dark">
                            <h3 class="card-title text-center">
                                <i class="fas fa-user"></i> Edit Admin Profile
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.profile.update', $admin) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $admin->name }}" name="name">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $admin->email }}" name="email">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="text" class="form-control bg-dark text-light" value=""
                                        name="password">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        name="password_confirmation">
                                    @error('password_confirmation')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layout>
