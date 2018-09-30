<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/tenant.js') }}" defer></script>
    @stack('scripts')

    <!-- Styles -->
    <link href="{{ mix('css/tenant.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper" id="app">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand"><strong>{{ config('app.name') }}</strong></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @if (auth()->check())
                                <li><a href="{{ route('home') }}">Home</a></li>
                                @if(auth()->user()->isSuperAdmin())
                                    <li><a  href="{{ route('branchOffices.index') }}">Sucursales</a></li>
                                @endif
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Administración de Usuario<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        @can('view', \App\User::class)
                                            <li><a href="{{ route('users.index') }}">Usuarios</a></li>
                                        @endcan
                                        <li class="divider"></li>
                                        @can('view', \Silber\Bouncer\Database\Role::class)
                                            <li><a  href="{{ route('roles.index') }}">Roles</a></li>
                                        @endcan
                                        <li class="divider"></li>
                                        <li><a href="{{ route('abilities.index') }}">Habilidades</a></li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->

                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs"> {{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="{{ asset('img/logo-itevo.png') }}">
                                        <p>
                                            {{ Auth::user()->name }} <br>
                                            {{ Auth::user()->email }}
                                            <small>Miembro desde {{ Auth::user()->created_at->diffForHumans() }}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-fla" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                               Cerrar Sesión
                                               <i class="fas fa-sign-out-alt"></i>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="content-wrapper">
            <div class="container">
                @yield('content')
            </div>
        </div>

        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                     {{--Desarrollado por ...--}}
                </div>
                <strong>Copyright &copy; {{ date('Y') }}
                    {{ config('app.name', 'Laravel') }}.
                </strong>
                Todos los derechos reservados.
            </div>
        </footer>
    </div>
</body>
</html>
