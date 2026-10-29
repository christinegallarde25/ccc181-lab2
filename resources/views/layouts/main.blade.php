<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Anahaw Amphitheatre') | Anahaw Amphitheatre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <nav class="navbar navbar-anahaw py-2">
        <div class="container d-flex flex-wrap align-items-center gap-3 gap-lg-4">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="{{ route('dashboard') }}">
                <img class="brand-logo flex-shrink-0" src="{{ asset('images/anahaw-amphitheatre-logo.jpeg') }}" alt="" width="36" height="36">
                <span>Anahaw Amphitheatre</span>
            </a>
            <div class="navbar-nav d-flex flex-row flex-wrap gap-lg-2">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">Bookings</a>
            </div>
            <div class="d-flex align-items-center gap-3 ms-lg-auto">
                <span>Hi, {{ \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::lower((string) \Illuminate\Support\Str::of(auth()->user()->name)->squish()->before(' '))) }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">Log out</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <p class="mb-1">Please correct the following errors:</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
