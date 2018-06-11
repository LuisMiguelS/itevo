<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="ITEVO" />
    <meta name="author" content="ITEVO" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

    <title>ITEVO | Login</title>

    <link rel="stylesheet" href="{{ asset('admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/font-icons/entypo/css/entypo.css') }}">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/neon-core.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/neon-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/neon-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">

    <script src="{{ asset('admin/js/jquery-1.11.3.min.js') }}"></script>

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">
    <div class="login-container">
        <div class="login-header login-caret">
            <div class="login-content">
                <a href="index.html" class="logo">
                    <img src="{{ asset('admin/images/logo@2x.png') }}" width="120" alt="itevo-logo" />
                </a>
                
                <p class="description">¡Hola!<br>Inicia sesión para acceder al área de administración.</p>
            </div>
        </div>
        
        <div class="login-progressbar">
            <div></div>
        </div>

        <div class="login-form">
            <div class="login-content">
                <form method="POST" action="{{ route('login') }}" id="form_login">
                    @csrf

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-user"></i>
                            </div>
                            
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" placeholder="Email" autocomplete="off" autofocus/>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-key"></i>
                            </div>
                            
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Password" autocomplete="off" />

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div> --}}
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-login">
                            <i class="entypo-login"></i>
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

                <div class="login-bottom-links">
                    <a href="{{ route('password.request') }}" class="link">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/js/gsap/TweenMax.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/js/joinable.js') }}"></script>
    <script src="{{ asset('admin/js/resizeable.js') }}"></script>
    <script src="{{ asset('admin/js/neon-api.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/neon-login.js') }}"></script>

    <script src="{{ asset('admin/js/neon-custom.js') }}"></script>
    <script src="{{ asset('admin/js/neon-demo.js') }}"></script>
</body>
</html>