<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel CMS') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">

    <style>
        trix-editor {
            min-height: 300px;
            background: #fff;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel Blog') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
        
                        
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('is_admin.categories.index') }}">Categories</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('posts.create') }}">New Post</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('is_admin.users.index') }}">Users</a>
                        </li>
                        
                        @endauth
                    </ul>
        
                    <ul class="navbar-nav">
                        @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li> --}}
                        @else
                        <li class="nav-item"><span class="nav-link">{{ auth()->user()->name }}</span></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">@csrf
                                <button class="btn btn-sm btn-outline-light">Logout</button>
                            </form>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


    <main class="container">
        @yield('content')
    </main>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Trix --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

</body>

</html>