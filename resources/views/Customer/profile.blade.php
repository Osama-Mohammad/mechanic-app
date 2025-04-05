<body class="bg-dark text-light">
    <x-layout>
        <x-nav />
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header bg-dark">
                            <h3 class="card-title text-center">
                                <i class="fas fa-user"></i> Customer Profile
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <p class="form-control bg-dark text-light">{{ $customer->name }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <p class="form-control bg-dark text-light">{{ $customer->phone }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <p class="form-control bg-dark text-light">{{ $customer->email }}</p>
                            </div>

                            {{--                             <div class="mb-3">
                                <label for="location" class="form-label">Location:</label>
                                <p class="form-control bg-dark text-light">{{ $customer->location }}</p>
                            </div> --}}




                            <div class="mb-3">
                                <label for="latitude" class="form-label">
                                    <i class="fas fa-map-marked-alt"></i> Latitude:
                                </label>
                                <input type="text" id="latitude" name="latitude"
                                    class="form-control bg-dark text-light placeholder-light"
                                    value="{{ $customer->latitude }}" readonly>
                                @error('latitude')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="longitude" class="form-label">
                                    <i class="fas fa-map-marked-alt"></i> Longitude:
                                </label>
                                <input type="text" id="longitude" name="longitude"
                                    class="form-control bg-dark text-light placeholder-light"
                                    value="{{ $customer->longitude }}" readonly>
                                @error('longitude')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">
                                    <i class="fas fa-city"></i> City:
                                </label>
                                <input type="text" id="location" name="location"
                                    class="form-control bg-dark text-light placeholder-light"
                                    value="{{ $customer->location }}" readonly>

                                @error('location')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>






                            <div class="d-grid">
                                <a href=" {{ route('customer.profile.edit', $customer->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Profile
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layout>
