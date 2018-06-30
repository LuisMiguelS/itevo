@extends('layouts.tenant')

@section('breadcrumb')
    <ol class="breadcrumb bc-3" >
        <li>
            <a href="{{ route('home') }}"><i class="fa fa-home"></i>Inicio</a>
        </li>

        <li class="active">
            <strong>Dashboard</strong>
        </li>
    </ol>
@endsection

@section('content')
    <div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="tile-stats tile-red">
			<div class="icon"><i class="fa fa-users"></i></div>
			<div class="num" data-start="0" data-end="83" data-postfix="" data-duration="1500" data-delay="0">0</div>

			<h3>Estudiantes</h3>
			<p>{{ $institute->name }}</p>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="tile-stats tile-green">
			<div class="icon"><i class="fa fa-dollar-sign"></i></div>
			<div class="num" data-start="0" data-end="13000" data-postfix="" data-duration="2000" data-delay="0">0</div>

			<h3>Ingresos del Día</h3>
			<p>Monto total de los ingresos del día</p>
		</div>
	</div>

	<div class="clear visible-xs"></div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="tile-stats tile-aqua">
			<div class="icon"><i class="fa fa-puzzle-piece"></i></div>
			<div class="num" data-start="0" data-end="5" data-postfix="" data-duration="1500" data-delay="1200">0</div>

			<h3>Cursos</h3>
			<p>Cursos de esta promoción</p>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="tile-stats tile-blue">
			<div class="icon"><i class="fa fa-calendar"></i></div>
			<div class="num" data-start="0" data-end="52" data-postfix="" data-duration="1500" data-delay="1800">0</div>

			<h3>Promociones</h3>
			<p>Todas las promociones</p>
		</div>
	</div>
</div>
@endsection
