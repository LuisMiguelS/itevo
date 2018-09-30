<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Scripts -->
    <script src="{{ mix('js/tenant.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/tenant.css') }}" rel="stylesheet">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <strong>{{ strtoupper(config('app.name')) }}</strong>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Iniciar sesión en {{ config('app.name') }}</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input name="email" type="email" class="form-control" placeholder="{{ __('E-Mail Address') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input name="password" type="password" class="form-control" placeholder="{{ __('Password') }}">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="row" style="padding-bottom: 2rem">
                <div class="col-xs-8">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>
                </div>
                <div class="col-xs-4"></div>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>

            <div style="padding-top: 1.5rem">
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
