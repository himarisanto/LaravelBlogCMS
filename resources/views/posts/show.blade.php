    <div class="row">
    <div class="col-md-8">
        <h1>{{ $post->title }}</h1>
        <p><small>By {{ $post->author->name }} | {{ $post->published_at->format('M d, Y') }}</small></p>
        @if($post->thumbnail)<img src="{{ asset('storage/'.$post->thumbnail) }}" class="img-fluid">@endif
        <div class="mt-3">{!! $post->body !!}</div>

        <hr>
        <h5>Comments</h5>
        @foreach($post->comments as $comment)
        <div class="mb-2"><strong>{{ $comment->user ? $comment->user->name : 'Guest' }}</strong>: {{ $comment->body }}</div>
        @endforeach

        @auth
        <form action="{{ route('comments.store') }}" method="POST">@csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="body" class="form-control" rows="3"></textarea>
            <button class="btn btn-primary mt-2">Submit</button>
        </form>
        @endauth
    </div>
    <div class="col-md-4">
        <h5>Categories</h5>
        <ul>
        @foreach($post->categories as $cat)
            <li><a href="{{ route('categories.show',$cat->slug) }}">{{ $cat->name }}</a></li>
        @endforeach
        </ul>
    </div>
    </div>
@endsection