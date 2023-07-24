<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>@yield('title', 'Home')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="/css/lightbox.css" rel="stylesheet" />


    <style>
        body {
            padding: 90px 20px 30px;
        }
        

    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="d-flex flex-column h-100">

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        
        <div class="container-fluid">
           
            <a class="navbar-brand" href="/dashboard/albums">PHOTOGALLERY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="navbar-nav me-auto mb-2 mb-lg-20 navbar-dark" id="navbarCollapse">
                @auth
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/dashboard/albums">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('albums.index')}}">Albums</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('albums.create')}}">New Album</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('photos.create')}}">New Image</a>
                        </li>
                    </ul>
            </div> {{--aggiunto per il css, rimuovere in caso di problemi--}}
                    <div class="navbar-nav me-200 mb-2 mb-lg-200" id="navbarCollapse">
                        <form class="d-flex" role="search">
                         <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                @endauth

                <ul class="nav navbar-nav navbar-right">

                    @guest
                        <li>
                            <a class="nav-link" href="{{route('login')}}">Login</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{route('register')}}">Register</a>
                        </li>
                    @endguest
                    
                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle  nav-link" data-bs-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>

                                    <form id="logout-form" action="{{ route('logout')}}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-default">Logout</button>
                                    </form>
                                </li>

                            </ul>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>
</header>

<main role="main" class="container">
    @yield('content')
    {{$slot ?? ''}}
</main><!-- /.container -->
@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="/js/lightbox.js"></script>
    <script>
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@show
</body>
</html>