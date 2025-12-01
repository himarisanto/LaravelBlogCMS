@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Categories</h1>
        <a href="{{ route('is_admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
    </div>

    @if($categories->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->slug }}</td>
                        <td>{{ $c->description }}</td>
                        <td>
                            <a href="{{ route('is_admin.categories.edit', $c->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('is_admin.categories.delete', $c->id) }}" class="d-inline" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $categories->links() }}
    @else
        <p>No categories found.</p>
    @endif
</div>
@endsection
