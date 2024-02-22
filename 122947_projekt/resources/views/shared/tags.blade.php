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
