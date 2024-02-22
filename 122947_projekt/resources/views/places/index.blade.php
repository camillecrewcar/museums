<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <title>Forum</title>

    <style>
        .star-rating {
            display: flex;
            align-items: center;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2rem;
            color: #fff;
            margin: 0;
            padding: 0;
            cursor: pointer;
        }

        .star-rating label:before {
            content: '\2606';
            border: 2px solid #fff;
            border-radius: 50%;
            padding: 0.3rem;
            margin: 0.2rem;
            color: gray;
        }

        .star-rating input:checked + label:before,
        .star-rating label:hover ~ input:checked + label:before {
            content: '\2605'; /* Update to filled star */
            color: gold;
        }
    </style>
</head>

<body>
    @include('shared.header')
    <div class="container">
        @if ($place->verified === 1)
            <br>
            <div class="alert alert-info">
                <h4>
                    This place has been verified!
                </h4>
            </div>
        @endif
        @auth
            @if (auth()->user()->role === 1)
                <form action="{{ route('admin.places.toggleVerification', $place->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-secondary">Toggle Verification</button>
                </form>
            @endif
        @endauth

    </div>


    <!-- Place Section -->
    <section class="py-4">
        <div class="container">
            <h1>{{ $place->name }}</h1>
            <!-- Image Carousel -->
            @if ($place->images->count() > 0)
                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($place->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/'.$image->source_url) }}" class="d-block w-100 img-fluid"
                                    alt="Place Image">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @endif
            <p>{{ $place->description }}</p>

            <!-- Opening hours -->
            <h3>Opening Hours</h3>
            @foreach ($openingHours as $openingHour)
                @if (!empty($openingHour->opening_time) && !empty($openingHour->closing_time))
                    @php
                        $dayOfWeek = [
                            1 => 'Monday',
                            2 => 'Tuesday',
                            3 => 'Wednesday',
                            4 => 'Thursday',
                            5 => 'Friday',
                            6 => 'Saturday',
                            7 => 'Sunday',
                        ][$openingHour->day_of_week];
                    @endphp
                    <p>{{ ucfirst($dayOfWeek) }}: {{ date('H:i', strtotime($openingHour->opening_time)) }} -
                        {{ date('H:i', strtotime($openingHour->closing_time)) }}</p>
                @endif
            @endforeach
            @auth
                @if (auth()->user()->hasSubmittedOpinionForPlace($place->id))
                    <p>You have already submitted your opinion for this place.</p>
                @else
                    <button type="button" class="btn btn-secondary" id="addOpinionButton">Add Opinion</button>

                    <form method="POST" id="addOpinionForm" style="display: none;" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="place_id" value="{{ $place->id }}">
                        <div class="form-group">
                            <label for="score">Rating:</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="score" value="1"
                                    {{ old('score', 0) == 5 ? 'checked' : '' }}>
                                <label for="star5"></label>
                                <input type="radio" id="star4" name="score" value="2"
                                    {{ old('score', 0) == 4 ? 'checked' : '' }}>
                                <label for="star4"></label>
                                <input type="radio" id="star3" name="score" value="3"
                                    {{ old('score', 0) == 3 ? 'checked' : '' }}>
                                <label for="star3"></label>
                                <input type="radio" id="star2" name="score" value="4"
                                    {{ old('score', 0) == 2 ? 'checked' : '' }}>
                                <label for="star2"></label>
                                <input type="radio" id="star1" name="score" value="5"
                                    {{ old('score', 0) == 1 ? 'checked' : '' }}>
                                <label for="star1"></label>
                            </div>
                        </div>
                        <p id="scoreDisplay"></p>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" accept="image/jpeg, image/png"
                                class="form-control-file" required>
                            <small class="text-muted">Accepted formats: JPEG, PNG</small>
                        </div>
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </form>
                @endif
            @endauth
        </div>
    </section>

    <div class="container mt-4">
        @foreach ($opinions as $opinion)
            <div class="card my-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $opinion->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Posted by: {{ $opinion->user->name }} | {{ $opinion->created_at->format('F j, Y H:i') }}
                    </h6>
                    <p class="card-text">{{ $opinion->description }}</p>
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $opinion->score)
                                <span class="star filled">&#9733;</span>
                            @else
                                <span class="star">&#9734;</span>
                            @endif
                        @endfor
                    </div>
                    <div class="admin-buttons">
                        @auth
                            @if (auth()->user()->role === 1)
                                <form action="{{ route('opinions.destroy', $opinion->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-primary edit-opinion"
                                    data-opinion-id="{{ $opinion->id }}">Edit</button>
                                <form method="POST" action="{{ route('opinions.update', $opinion->id) }}"
                                    class="edit-opinion-form" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="opinion_id" value="{{ $opinion->id }}">
                                    <div class="form-group">
                                        <label for="editOpinionDescription">Description:</label>
                                        <textarea class="form-control edit-opinion-description"
                                            name="description" rows="3">{{ $opinion->description }}</textarea>
                                    </div>
                                    <button type="button" class="btn btn-secondary cancel-edit">Cancel</button>
                                    <button type="submit" class="btn btn-primary update-opinion">Update</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addOpinionButton = document.getElementById('addOpinionButton');
            const opinionForm = document.getElementById('opinionForm');
            const ratingStars = document.querySelectorAll('.star');
            const opinionCards = document.querySelectorAll('.card.my-4');
            const editOpinionForms = document.querySelectorAll('.edit-opinion-form');
            const editButtons = document.querySelectorAll('.edit-opinion');
            const cancelButtons = document.querySelectorAll('.cancel-edit');

            addOpinionButton.addEventListener('click', () => {
                opinionForm.style.display = 'block';
            });

            ratingStars.forEach((star) => {
                star.addEventListener('click', (event) => {
                    const selectedStar = event.target;
                    const ratingContainer = selectedStar.parentElement;
                    const stars = ratingContainer.querySelectorAll('.star');

                    stars.forEach((star) => {
                        star.classList.remove('filled');
                    });

                    selectedStar.classList.add('filled');
                });
            });

            editButtons.forEach((button, index) => {
                button.addEventListener('click', () => {
                    opinionCards[index].classList.add('editing');
                    editOpinionForms[index].style.display = 'block';
                });
            });

            cancelButtons.forEach((button, index) => {
                button.addEventListener('click', () => {
                    opinionCards[index].classList.remove('editing');
                    editOpinionForms[index].style.display = 'none';
                });
            });
        });
    </script>
</body>

</html>
