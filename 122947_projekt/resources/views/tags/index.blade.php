<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <title>Forum</title>
  </head>

<body>
    @include('shared.header')

    <section class="py-4">

        <div class="container">
            <h1>Threads connected to {{ $tag }}</h1>

            <ul>
                @foreach ($threads as $thread)
                    <li>{{ $thread->title }}</li>
                @endforeach
            </ul>
        </div>

      </section>
</body>
