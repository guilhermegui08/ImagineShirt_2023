<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('titulo')</title>
    @vite('resources/sass/app.scss')
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand " href="{{ route('home') }}">
        <img src="/img/plain_white.png" alt="Logo" class="bg-dark" width="80" height="52">
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars"></i></button>
    @guest
        <ul class="navbar-nav ms-auto me-1 me-lg-3">
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </li>
            @endif
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </li>
            @endif
        </ul>
    @else
        <div class="ms-auto me-0 me-md-2 my-2 my-md-0 navbar-text">
            {{ Auth::user()->name}}
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav me-1 me-lg-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->fullPhotoUrl }}" alt="Avatar"
                         class="bg-dark rounded-circle" width="45" height="45">
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    @if ((Auth::user()->user_type ?? '') == 'C')
                        <li><a class="dropdown-item" href="{{ route('customers.show', ['customer' => Auth::user()->customer]) }}">Perfil</a></li>
                    @endif
                    @if ((Auth::user()->user_type ?? '') == 'A')
                            <li><a class="dropdown-item" href="{{ route('users.show', ['user' => Auth::user()]) }}">Perfil</a></li>
                        @endif
                    <li><a class="dropdown-item" href="{{route('password.change.show')}}">Alterar Senha</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Sair
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    @endguest
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    @if(!Auth::user() || Auth::user()->user_type != 'E')
                    <a class="nav-link" href="{{route('tshirt_images.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Catálogo
                    </a>
                    @endif
                    <a class="nav-link" href="{{route('orders.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                        Orders
                    </a>
                    @if(Auth::user() != null and Auth::user()->user_type == 'A')
                        <a class="nav-link" href="{{route('customers.index')}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Customers
                        </a>
                        <a class="nav-link" href="{{route('users.index')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                            Users
                        </a>
                        <a class="nav-link" href="{{route('statistics.index')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-chart-bar"></i></div>
                            Statistics
                        </a>
                    @endif
                        @if( !Auth::user() || Auth::user()->user_type != 'E')
                    <a class="nav-link" href="{{route('cart.show')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                        Shopping Cart
                    </a>
                    @can('administrate')
                        <a class="nav-link" href="{{route('categories.index')}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-tags"></i></div>
                            Categories
                        </a>
                        <a class="nav-link" href="{{route('colors.index')}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-droplet"></i></div>
                            Colors
                        </a>
                        <a class="nav-link" href="{{route('prices.show')}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                            Prices
                        </a>
                    @endcan
                        @endif
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                @if (session('alert-msg'))
                    @include('shared.messages')
                @endif
                @if ($errors->any())
                    @include('shared.alertValidation')
                @endif
                <h1 class="mt-4">@yield('titulo', 'Politécnico de Leiria')</h1>
                @yield('subtitulo')
                <div class="mt-4">
                    @yield('main')
                </div>
            </div>
        </main>
        <footer class="py-2 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy;Politécnico de Leiria 2023</div>
                </div>
            </div>
        </footer>
    </div>
</div>
@vite('resources/js/app.js')
</body>

</html>
