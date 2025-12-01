@extends('layouts.app')
@section('content')
<h1>Category: {{ $category->name }}</h1>
<form class="d-flex mb-3" action="" method="GET">
  <input class="form-control me-2" name="q" type="search" placeholder="Search in category" value="{{ request('q') }}">
  <button class="btn btn-outline-success">Search</button>
</form>
@foreach($posts as $post)
  <div class="mb-3">
    <h3><a href="{{ route('posts.show',$post->slug) }}">{{ $post->title }}</a></h3>
    <p>{{ $post->excerpt }}</p>
  </div>
@endforeach
{{ $posts->links() }}
@endsection
