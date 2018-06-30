<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/tenant_panel.js') }}" defer></script>
    @stack('scripts')

    <!-- Styles -->
    <link href="{{ mix('css/tenant_panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

</head>
<body class="page-body">
	<div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-menu-inner">
                <header class="logo-env">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/logo-itevo.png') }}" width="120"/>
                        </a>
                    </div>

                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon with-animation">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>

                    <div class="sidebar-mobile-menu visible-xs">
                        <a href="#" class="with-animation">
                            <i class="entypo-menu"></i>
                        </a>
                    </div>
                </header>

                <div class="sidebar-user-info">
                    <div class="sui-normal">
                        <a class="user-link">
                            <strong>{{ Auth()->user()->name }}</strong>
                        </a>
                    </div>
                </div>

                <ul id="main-menu" class="main-menu">
                    @include('partials.sidebar')
                </ul>
            </div>
        </div>

		<div class="main-content">
            <div class="row">
                <div class="col-md-6 col-sm-8 clearfix">
                    <ul class="list-inline links-list pull-left">
                        <li class="nav-item">
                            {{ $institute->name }}
                        </li>
                    </ul>
                </div>

                <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                    <ul class="list-inline links-list pull-right">
                        <li class="nav-item dropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Cerrar Sesión
                                <i class="fas fa-sign-out-alt"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <hr/>

            <div class="container-fluid" style="min-height: 100vh;">
                @yield('breadcrumb')

                @include('partials.alert-tenant')

                @yield('content')
            </div>

            <footer class="main">
                Copyright &copy; {{ date('Y') }} <strong>{{ config('app.name', 'Laravel') }}</strong> Todos los derechos reservados.
            </footer>
		</div>
	</div>
</body>
</html>
