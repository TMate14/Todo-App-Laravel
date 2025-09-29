<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Todo App')</title>
    @vite(['resources/css/app.css'])
</head>

<body>
    <div class="container">
        @auth
            <div class="header">
                <h1>@yield('title', 'My Tasks')</h1>
                <div>
                    <span>{{ Auth::user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-secondary" style="margin-left: 10px;">Logout</button>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center mb-3">
                <h1>@yield('title', 'Todo App')</h1>
            </div>
        @endauth

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>

</html>