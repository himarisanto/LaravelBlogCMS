@extends('layouts.app')

@section('content')
<h1>User Management</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role }}</td>
            <td>{{ $u->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection
