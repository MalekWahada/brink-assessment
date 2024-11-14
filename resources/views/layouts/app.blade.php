<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Brink Link Shortener')</title>
    <link rel="icon" type="image/x-icon" href="https://cdn.thebrinkagency.com/3045d68e970bb1954ae3321f7b23213a.gif">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="https://www.thebrinkagency.com/">The brink</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('url.create') }}">Shorten Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('url.admin') }}">Admin Panel</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<div class="container mt-4">
    @yield('content')
</div>

<footer class="mt-4 bg-light p-3">
    <p class="text-center">© {{now()->year}} Brink Link Shortener</p>
</footer>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@show
</body>
</html>
