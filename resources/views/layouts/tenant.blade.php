<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Scripts -->
    <script src="{{ mix('js/tenant.js') }}" defer></script>
    @stack('scripts')

    <!-- Styles -->
    <link href="{{ mix('css/tenant.css') }}" rel="stylesheet">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('partials._navbar_tenant')


    @include('partials._sidebar_tenant')

    <div class="content-wrapper">
        <section class="content-header">
            @section('content_title')
                <h1> {{ $branchOffice->name }} </h1>
            @show

            @yield('breadcrumb')
        </section>

        <section class="content">
            @include('partials._alert')

            @yield('content')
        </section>
    </div>

    <footer class="main-footer">
        Copyright &copy; {{ date('Y') }} <strong>{{ config('app.name', 'Laravel') }}</strong> Todos los derechos reservados.
    </footer>
</div>
</body>
</html>
