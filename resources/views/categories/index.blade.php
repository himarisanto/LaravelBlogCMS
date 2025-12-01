@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Categories</h1>

    <ul>
        @foreach ($categories as $cat)
        <li>
            <a href="{{ route('categories.show', $cat->slug) }}">
                {{ $cat->name }}
            </a>
        </li>
        @endforeach
    </ul>

    {{ $categories->links() }}
</div>
@endsection