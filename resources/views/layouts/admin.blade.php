<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="ITEVO" />
	<meta name="author" content="Simple Code" />

	<link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

	<title>ITEVO | Dashboard</title>

	<link rel="stylesheet" href="{{ asset('admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/font-icons/entypo/css/entypo.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/neon-core.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/neon-theme.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/neon-forms.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/skins/black.css') }}">
	@yield('styles')

	<script src="{{ asset('admin/js/jquery-1.11.3.min.js') }}"></script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="page-body skin-black">
	<div class="page-container">
		@include('layouts.includes.sidebar')

		<div class="main-content">
			@include('layouts.includes.navbar')
			
			@yield('content')
			
			@include('layouts.includes.footer')
		</div>
	</div>

	<!-- Bottom scripts (common) -->
	<script src="{{ asset('admin/js/gsap/TweenMax.min.js') }}"></script>
	<script src="{{ asset('admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}"></script>
	<script src="{{ asset('admin/js/bootstrap.js') }}"></script>
	<script src="{{ asset('admin/js/joinable.js') }}"></script>
	<script src="{{ asset('admin/js/resizeable.js') }}"></script>
	<script src="{{ asset('admin/js/neon-api.js') }}"></script>

	<!-- Imported scripts on this page -->
	<script src="{{ asset('admin/js/raphael-min.js') }}"></script>
	<script src="{{ asset('admin/js/toastr.js') }}"></script>

	<!-- JavaScripts initializations and stuff -->
	<script src="{{ asset('admin/js/neon-custom.js') }}"></script>

	<!-- Demo Settings -->
	<script src="{{ asset('admin/js/neon-demo.js') }}"></script>
	@yield('scripts')
</body>
</html>