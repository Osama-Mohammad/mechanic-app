<x-layout>
    <x-nav />

    <style>
        /* Custom CSS to make placeholder text visible */
        .placeholder-light::placeholder {
            color: #ccc;
            opacity: 1;
        }

        /* Custom CSS for rating */
        .rating {
            color: #FFD700; /* Gold color for stars */
            font-weight: bold;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-center">
                            <i class="fas fa-tools"></i> Report a Problem
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('emergency.request.store', Auth::guard('customer')->user()) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea id="description" name="description" class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Describe the Problem...." rows="4"></textarea>
                                @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mechanics" class="form-label">Mechanics:</label>
                                <div class="input-group">
                                    <select name="mechanics" class="form-control bg-dark text-light">
                                        @foreach ($mechanics as $mechanic)
                                            <option value="{{ $mechanic->id }}">
                                                {{ $mechanic->name }} - <span class="rating">{{ number_format($mechanic->average_rating, 1) }} ⭐</span>
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text bg-dark border-dark">
                                        <i class="fas fa-caret-down text-light"></i>
                                    </span>
                                </div>
                                @error('mechanics')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="responseTime" class="form-label">Response Time:</label>
                                <input type="date" id="responseTime" name="responseTime"
                                    class="form-control bg-dark text-light placeholder-light">
                                @error('responseTime')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-paper-plane"></i> Submit Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
