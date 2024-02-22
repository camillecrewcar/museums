<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <title>Forum</title>
</head>

<body>
    @include('shared.header')

    <!-- Tags Section -->
    <section class="py-4">
        <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2 class="text-secondary">Tags</h2>
            </div>
            @foreach ($tags as $tag)
            <div class="col-md-2">
            <div class="card mb-3">
                <a href="{{ route('tags.index', ['id' => $tag->id]) }}" class="btn btn-secondary">{{ $tag->name }}</a>
            </div>
            </div>
            @endforeach
        </div>
        </div>
    </section>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $thread->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Posted by: {{ $thread->user->name }}</h6>
                <p class="card-text">{{ $thread->description }}</p>
            </div>
        </div>
        @auth


        <div class="mt-4">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                <div class="mb-3">
                    <label for="description" class="form-label">Add Comment</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <button type="submit" onclick="handleCommentAdd()" class="btn btn-secondary">Submit</button>
            </form>
        </div>
        @endauth

        <div class="mt-4">
            <h4>Comments:</h4>

            @if ($thread->comments->count() > 0)

            @foreach ($thread->comments as $comment)
                @php
                $commentId = $comment->id;

                $commentLikes = $likes->where('comment_id', $commentId);
                @endphp
                @auth
                    @php


                $positiveLike = $likes->first(function ($like) use ($commentId) {
                    return $like['comment_id'] === $commentId && $like['isPositive'] && $like['user_id'] === auth()->user()->id;
                });
                $liked = !is_null($positiveLike);
                Log::info('Liked: ' . $liked);

                $negativeLike = $likes->first(function ($like) use ($commentId) {
                    return $like['comment_id'] === $commentId && !$like['isPositive'] && $like['user_id'] === auth()->user()->id;
                });
                $disliked = !is_null($negativeLike);
                Log::info('Disliked: ' . $disliked);
                    @endphp
                @endauth

                <div class="comment-cards">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Comment by: {{ $comment->user->name }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Added: {{ $comment->created_at }}</h6>
                            <p class="card-text">{{ $comment->description }}</p>
                            <div class="btn-group" role="group">
                            @auth
                            <button type="button" class="btn {{ $liked ? 'btn-success active' : 'btn-primary' }} like-btn" data-comment-id="{{ $comment->id }}" data-liked="{{ $liked ? 'true' : 'false' }}">
                                {{ $liked ? 'Liked' : 'Like' }}
                            </button>

                            <button type="button" class="btn {{ $disliked ? 'btn-danger active' : 'btn-secondary' }} dislike-btn" data-comment-id="{{ $comment->id }}" data-disliked="{{ $disliked ? 'true' : 'false' }}">
                                {{ $disliked ? 'Disliked' : 'Dislike' }}
                            </button>
                            @else
                                <a href="{{ route('login') }}" class="login-link">Login to Like</a>
                            @endauth
                                <div class="likes-container">
                                    <h6>Likes:</h6>
                                    <span>
                                        @php
                                        $likePoints = 0;
                                        if ($likes) {
                                            foreach ($commentLikes as $like) {
                                                if ($like->isPositive) {
                                                    $likePoints += 1;
                                                } else {
                                                    $likePoints -= 1;
                                                }
                                            }
                                        }
                                        echo $likePoints;
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No comments yet.</p>
        @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            const likeButtons = document.querySelectorAll('.like-btn');
            const dislikeButtons = document.querySelectorAll('.dislike-btn');
            const commentCards = document.querySelectorAll('.comment-cards .card');

            function handleLikeButtonClick(event) {
                const commentId = event.target.dataset.commentId;
                const liked = event.target.dataset.liked === 'true';
                const dislikeButton = event.target.parentElement.querySelector('.dislike-btn');
                const disliked = dislikeButton.dataset.disliked === 'true';
                const likesContainer = event.target.parentElement.querySelector('.likes-container span');
                let likePoints = parseInt(likesContainer.textContent);

                if (!liked) {
                    // Send an AJAX request to increment the likes count for the comment
                    axios
                        .post('/comments/like', { commentId })
                        .then((response) => {
                            // Update the like count and change the button styles after a successful response
                            event.target.classList.remove('btn-primary');
                            event.target.classList.add('btn-success');
                            event.target.innerText = 'Liked';
                            likePoints++;
                            likesContainer.textContent = likePoints;
                            event.target.dataset.liked = 'true';

                            if (disliked) {
                                dislikeButton.classList.remove('btn-danger');
                                dislikeButton.classList.add('btn-secondary');
                                dislikeButton.innerText = 'Dislike';
                                likePoints++;
                                likesContainer.textContent = likePoints;
                                dislikeButton.dataset.disliked = 'false';
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    // Send an AJAX request to decrement the likes count for the comment
                    axios
                        .post('/comments/unlike', { commentId })
                        .then((response) => {
                            // Update the like count and change the button styles after a successful response
                            event.target.classList.remove('btn-success');
                            event.target.classList.add('btn-primary');
                            event.target.innerText = 'Like';
                            likePoints--;
                            likesContainer.textContent = likePoints;
                            event.target.dataset.liked = 'false';
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            function handleDislikeButtonClick(event) {
                const commentId = event.target.dataset.commentId;
                const disliked = event.target.dataset.disliked === 'true';
                const likeButton = event.target.parentElement.querySelector('.like-btn');
                const liked = likeButton.dataset.liked === 'true';
                const likesContainer = event.target.parentElement.querySelector('.likes-container span');
                let likePoints = parseInt(likesContainer.textContent);

                function updateButtonStates() {
                    commentCards.forEach((card) => {
                        const commentId = card.querySelector('.like-btn').dataset.commentId;
                        const liked = card.querySelector('.like-btn').dataset.liked === 'true';
                        const disliked = card.querySelector('.dislike-btn').dataset.disliked === 'true';

                        if (liked) {
                            card.querySelector('.like-btn').classList.add('active');
                        } else {
                            card.querySelector('.like-btn').classList.remove('active');
                        }

                        if (disliked) {
                            card.querySelector('.dislike-btn').classList.add('active');
                        } else {
                            card.querySelector('.dislike-btn').classList.remove('active');
                        }
                    });
                }


                if (!disliked) {
                    // Send an AJAX request to increment the dislikes count for the comment
                    axios
                        .post('/comments/dislike', { commentId })
                        .then((response) => {
                            // Update the dislike count and change the button styles after a successful response
                            event.target.classList.remove('btn-secondary');
                            event.target.classList.add('btn-danger');
                            event.target.innerText = 'Disliked';
                            likePoints--;
                            likesContainer.textContent = likePoints;
                            event.target.dataset.disliked = 'true';

                            if (liked) {
                                likeButton.classList.remove('btn-success');
                                likeButton.classList.add('btn-primary');
                                likeButton.innerText = 'Like';
                                likePoints--;
                                likesContainer.textContent = likePoints;
                                likeButton.dataset.liked = 'false';
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    // Send an AJAX request to decrement the dislikes count for the comment
                    axios
                        .post('/comments/undislike', { commentId })
                        .then((response) => {
                            // Update the dislike count and change the button styles after a successful response
                            event.target.classList.remove('btn-danger');
                            event.target.classList.add('btn-secondary');
                            event.target.innerText = 'Dislike';
                            likePoints++;
                            likesContainer.textContent = likePoints;
                            event.target.dataset.disliked = 'false';
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }
            function updateButtonStates() {
            commentCards.forEach((card) => {
                const commentId = card.querySelector('.like-btn').dataset.commentId;
                const liked = card.querySelector('.like-btn').dataset.liked;
                const disliked = card.querySelector('.dislike-btn').dataset.disliked === 'true';
                console.log(liked)
                if (liked) {
                    card.querySelector('.like-btn').classList.add('active');
                } else {
                    card.querySelector('.like-btn').classList.remove('active');
                }

                if (disliked) {
                    card.querySelector('.dislike-btn').classList.add('active');
                } else {
                    card.querySelector('.dislike-btn').classList.remove('active');
                }
            });
        }


            likeButtons.forEach((button) => {
                button.addEventListener('click', handleLikeButtonClick);
            });

            dislikeButtons.forEach((button) => {
                button.addEventListener('click', handleDislikeButtonClick);
            });
            updateButtonStates();
        })();
        function handleCommentAdd(event) {
            var description = document.getElementById("description").value;

            if (description.trim() === "") {
                alert("Description is required.");
                event.preventDefault();
                return;
            }

            if (description.length > 1000) {
                alert("Description cannot exceed 1000 characters.");
                event.preventDefault();
                return;
            }
        }

        var form = document.querySelector('form');
        form.addEventListener('submit', handleFormSubmit);


    </script>
</body>

</html>
