<body class="bg-dark text-light">
    <x-layout>
        <x-nav />
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header bg-dark">
                            <h3 class="card-title text-center">
                                <i class="fas fa-user"></i> Edit Mechanic Profile
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('mechanic.profile.update', $mechanic) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->name }}" name="name">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->phone }}" name="phone">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->email }}" name="email">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Experience:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->experience }}" name="experience">
                                    @error('experience')
                                        {{ $message }}
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="availability" class="form-label">Availability:</label>
                                    <div class="input-group">
                                        <select name="availability" id="availability"
                                            class="form-control bg-dark text-light">
                                            <option value="Available">Available</option>
                                            <option value="Busy">Busy</option>
                                            <option value="Offline">Offline</option>
                                        </select>
                                        <span class="input-group-text bg-dark border-dark">
                                            <i class="fas fa-caret-down text-light"></i>
                                        </span>
                                    </div>
                                    @error('availability')
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
