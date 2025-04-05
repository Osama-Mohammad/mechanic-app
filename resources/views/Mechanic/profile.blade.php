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
                            <label class="form-label">
                                <i class="fas fa-user-tag me-2"></i>Name:
                            </label>
                            <p class="form-control bg-dark text-light py-2">{{ $mechanic->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-phone me-2"></i>Phone:
                            </label>
                            <p class="form-control bg-dark text-light py-2">+961 {{ $mechanic->phone }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email:
                            </label>
                            <p class="form-control bg-dark text-light py-2">{{ $mechanic->email }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-briefcase me-2"></i>Experience:
                            </label>
                            <p class="form-control bg-dark text-light py-2">
                                {{ $mechanic->experience }} {{ $mechanic->experience == 1 ? 'Year' : 'Years' }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar-check me-2"></i>Availability:
                            </label>
                            <p class="form-control bg-dark text-light py-2">
                                {{ $mechanic->availability }}
                                @if($mechanic->availability == 'Available')
                                    <span class="badge bg-success ms-2">Now Available</span>
                                @else
                                    <span class="badge bg-danger ms-2">Currently Busy</span>
                                @endif
                            </p>
                        </div>



                        <div class="mb-3">
                            <label for="latitude" class="form-label">
                                <i class="fas fa-map-marked-alt"></i> Latitude:
                            </label>
                            <input type="text" id="latitude" name="latitude"
                                class="form-control bg-dark text-light placeholder-light"
                                value="{{ $mechanic->latitude }}" readonly>
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
                                value="{{ $mechanic->longitude }}" readonly>
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
                                value="{{ $mechanic->location }}" readonly>

                            @error('location')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>





                        <!-- Simplified Work Schedule Section -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>Work Schedule:
                            </label>
                            <div class="form-control bg-dark text-light p-3">
                                <!-- Simple Days List -->
                                <div class="mb-3">
                                    <p class="mb-2"><strong>Working Days:</strong></p>
                                    <p>{{ implode(', ', $selected_days) }}</p>
                                </div>

                                <!-- Simple Time Display -->
                                <div>
                                    <p class="mb-2"><strong>Working Hours:</strong></p>
                                    <p>
                                        {{ \Carbon\Carbon::parse($mechanic->start_time)->format('h:i A') }}
                                        to
                                        {{ \Carbon\Carbon::parse($mechanic->end_time)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <a href="{{ route('mechanic.profile.edit', $mechanic) }}" class="btn btn-warning py-2">
                                <i class="fas fa-edit me-2"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
