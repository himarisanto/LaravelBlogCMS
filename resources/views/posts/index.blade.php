    <h1>Posts</h1>
    <div class="row">
    @foreach($posts as $post)
        <div class="col-md-6 mb-3">
        <div class="card">
            @if($post->thumbnail)<img src="{{ asset('storage/'.$post->thumbnail) }}" class="card-img-top">@endif
            <div class="card-body">
            <h5><a href="{{ route('posts.show',$post->slug) }}">{{ $post->title }}</a></h5>
            <p>{{ $post->excerpt }}</p>
            <small>By {{ $post->author->name }} | {{ $post->published_at?->format('M d, Y') }}</small>
            </div>
        </div>
        </div>
    @endforeach
    </div>
