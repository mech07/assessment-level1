<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Laravel</title>
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand no-underline" href="{{ url('/users') }}">
                List of Users
            </a>
            <a class="navbar-brand no-underline" href="{{ url('/users/create') }}">
                Create User
            </a>
            <a class="navbar-brand no-underline" href="{{ url('/users/trashed') }}">
                Trashed User
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">
                Logout
            </a>
            <!-- Add navigation links here -->
        </div>
    </nav>
    @endauth
    <div class="container mt-4">
        <!-- This is where the content will be injected -->
        @yield('content')
    </div>

    <footer class="text-center mt-5">
        <p>&copy; {{ date('Y') }} My Application</p>
    </footer>
</body>
</html>
