<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
  <title>Forum</title>
  <style>
    .fade-in {
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
    }

    .fade-in.active {
      opacity: 1;
    }
  </style>
</head>

<body>
  <!-- Header -->
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

  <section class="py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <button id="addThreadBtn" class="btn btn-secondary">Add Thread</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Add Thread Form -->
<section id="addThreadForm" class="py-4" style="display: none;">
    <div class="container">
      <form action="{{ route('threads.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="6" style="height: 300px;"></textarea>
        </div>
        <div class="mb-3">
          <label for="tags" class="form-label">Tags (separated by comma)</label>
          <input type="text" class="form-control" id="tags" name="tags">
        </div>
        <button type="submit" class="btn btn-secondary">Submit</button>
      </form>
    </div>
  </section>


  <!-- Recent Topics Section -->
  <section class="py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-secondary">Recent Topics @if (isset($selectedTag)) : {{ $selectedTag->name }}@endif</h2>
        </div>
        @foreach ($threads as $thread)
        <div class="col-md-12">
          <div class="card mb-3">
            <div class="card-body">
              <h6 class="card-title">{{ $thread->user->name }}</h6>
              <h3 class="card-title">{{ $thread->title }}</h3>
              <h5 class="card-title">{{ Str::limit($thread->description, 200) }}</h5>
              <br>
              <a href="{{ route('threads.index', ['id' => $thread->id]) }}" class="btn btn-secondary">read more...</a>
              @auth
              @if(auth()->user()->role === 1)
                  <!-- Show delete button for admin user -->
                  <form action="{{ route('thread.destroy', ['id' => $thread->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
              @endif
            @endauth
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <script>
    document.getElementById('addThreadBtn').addEventListener('click', function () {
      const form = document.getElementById('addThreadForm');
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
      form.classList.add('active');
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
