
    <x-layout>
        <x-nav />
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header bg-dark">
                            <h3 class="card-title text-center">
                                <i class="fas fa-user"></i> Edit Customer Profile
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="/customer/profile/edit/{{ $customer->id }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $customer->name }}" name="name">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $customer->phone }}" name="phone">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $customer->email }}" name="email">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $customer->location }}" name="location">
                                    @error('location')
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
