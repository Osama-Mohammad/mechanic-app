<x-layout>
    <x-nav />

    <style>
        /* Custom CSS to make placeholder text visible */
        .placeholder-light::placeholder {
            color: #ccc;
            opacity: 1;
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
                            <i class="fas fa-star"></i> Submit a Review
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label for="rating" class="form-label">Rating:</label>
                                <div class="star-rating" id="star-rating">
                                    <span class="star selected" data-value="1"><i class="fas fa-star"></i></span>
                                    <span class="star" data-value="2"><i class="fas fa-star"></i></span>
                                    <span class="star" data-value="3"><i class="fas fa-star"></i></span>
                                    <span class="star" data-value="4"><i class="fas fa-star"></i></span>
                                    <span class="star" data-value="5"><i class="fas fa-star"></i></span>
                                </div>
                                <input type="hidden" name="rating" id="rating" value="0">
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment:</label>
                                <textarea id="comment" name="comment" class="form-control bg-dark text-light placeholder-light" rows="4"
                                    placeholder="Leave a comment..."></textarea>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-paper-plane"></i> Submit Review
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
