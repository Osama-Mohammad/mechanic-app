<x-layout>
    <x-nav />

    <!-- Flash Message Section -->
    @if (session('info'))
        <div class="alert alert-info text-center">
            {{ session('info') }}
        </div>
    @endif

    <style>
        /* Custom CSS to make placeholder text visible */
        .placeholder-light::placeholder {
            color: #ccc;
            opacity: 1;
        }

        .alert-info {
            background-color: #d1ecf1;
            /* Light blue background */
            color: #0c5460;
            /* Dark blue text */
            border: 1px solid #bee5eb;
            /* Light blue border */
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        /* Star rating styling */
        .star-rating {
            display: flex;
            justify-content: center;
            gap: 5px;
            font-size: 24px;
            cursor: pointer;
        }

        .star-rating .star {
            color: #ccc;
            transition: color 0.2s;
        }

        .star-rating .star.selected,
        .star-rating .star:hover {
            color: #ffcc00;
        }

        .star-rating .star:hover~.star {
            color: #ccc;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-center">
                            <i class="fas fa-star"></i> Update Review
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reviews.update', $review) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-2">
                                <label for="rating" class="form-label">Rating:</label>
                                <div class="star-rating" id="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $review->rating ? 'selected' : '' }}"
                                            data-value="{{ $i }}">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="{{ $review->rating }}">
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment:</label>
                                <textarea id="comment" name="comment" class="form-control bg-dark text-light placeholder-light" rows="4"
                                    placeholder="Leave a comment...">{{ $review->comment }}</textarea>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-paper-plane"></i> Update Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for star rating functionality
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingInput.value = value;

                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('selected');
                    } else {
                        s.classList.remove('selected');
                    }
                });
            });
        });
    </script>
</x-layout>
