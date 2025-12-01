@extends('layouts.app')

@section('content')

<h1>Create Post</h1>
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">@csrf
    <div class="mb-3"><input name="title" class="form-control" placeholder="Title" required></div>
    <div class="mb-3"><input type="file" name="thumbnail" class="form-control"></div>
    <div class="mb-3">
        <select name="categories[]" multiple class="form-control">
        @foreach($categories as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
        </select>
    </div>
    <div class="mb-3"><textarea name="body" class="form-control wysiwyg"></textarea></div>
    <div class="mb-3"><input type="datetime-local" name="published_at" class="form-control"></div>
  <button class="btn btn-primary">Save</button>
</form>
@endsection
