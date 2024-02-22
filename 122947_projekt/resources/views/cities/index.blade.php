<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <title>Forum</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  </head>


<body>
    @include('shared.header')
    <br>
    <div class="container">
        @auth
            <div class="mb-4">
                <a href="{{ route('places.create') }}" class="btn btn-secondary">Create New Place</a>
            </div>
        @endauth

        @if(isset($city))
            <h1>Close places to {{ $city->name }}</h1>
        @endif
        @if(isset($filteredPlaces))
        <div class="row">
            @foreach ($filteredPlaces as $place)
            <div class="col-md-3">
                <div class="card mb-3">
                    <a href="{{ route('place.show', ['id' => $place->id]) }}" class="card-link">
                        <div class="card-body">
                            @if ($place->images->count() > 0)
                                <img src="{{ asset('storage/'.$place->images->first()->source_url) }}" alt="Place Image" class="card-img">
                            @else
                                <p>No photo added</p>
                            @endif
                            <br>
                            <br>
                            <h5 class="card-title">{{ $place->name }}</h5>
                            <hr>
                            <ul class="list-unstyled">
                                <li>{{ Str::limit($place->description, 100) }}</li>
                            </ul>

                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="row">
            @foreach ($places as $place)
            <div class="col-md-3">
                <div class="card mb-3">
                    <a href="{{ route('place.show', ['id' => $place->id]) }}" class="card-link">
                        <div class="card-body">
                            @if ($place->images->count() > 0)
                                <img src="{{ asset('storage/'.$place->images->first()->source_url) }}" alt="Place Image" class="card-img">
                            @else
                                <p>No photo added</p>
                            @endif
                            <br>
                            <br>
                            <h5 class="card-title">{{ $place->name }}</h5>
                            <hr>
                            <ul class="list-unstyled">
                                <li>{{ Str::limit($place->description, 100) }}</li>
                            </ul>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>

</body>
</html>
