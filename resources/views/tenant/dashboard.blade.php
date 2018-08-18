@extends('layouts.tenant')

@section('title', 'Dashboard')

@section('breadcrumb')
    {{ Breadcrumbs::render('dashboard', $branchOffice) }}
@endsection

@section('content')

	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>{{ $branchOffice->students()->where('signed_up', '<>', null)->count() }}</h3>
					<p><strong>Cantidad de Estudiantes</strong></p>
				</div>
				<div class="icon">
					<i class="fa fa-users"></i>
				</div>
				<a href="{{ route('tenant.students.index', $branchOffice) }}" class="small-box-footer">Ver detalle <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>100,000.00</h3>

					<p><strong>Ingresos del día</strong></p>
				</div>
				<div class="icon">
					<i class="fa fa-dollar"></i>
				</div>
				<a href="#" class="small-box-footer">Ver detalle <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>
						@if($branchOffice->currentPromotion()->currentPeriod())
							{{ $branchOffice->currentPromotion()->currentPeriod()->coursePeriods()->count() }}
						@else
							0
						@endif
					</h3>

					<p><strong>Cursos activos</strong></p>
				</div>
				<div class="icon">
					<i class="fa fa-list"></i>
				</div>
                @if($branchOffice->currentPromotion()->currentPeriod())
                    <a href="{{ route('tenant.periods.course-period.index', ['branchOffice' => $branchOffice, 'period' => $branchOffice->currentPromotion()->currentPeriod()]) }}" class="small-box-footer">
                        Ver detalle
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @endif

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">

			<div class="small-box bg-red">
				<div class="inner">
					<h3>{{ $branchOffice->currentPromotion()->promotion_no ?? 0 }}</h3>

					<p><strong>{{ $branchOffice->currentPromotion() ? 'Promoción en curso' : 'No hay promoción en curso' }}</strong></p>
				</div>
				<div class="icon">
					<i class="fa fa-spinner"></i>
				</div>
				<a href="{{ $branchOffice->currentPromotion()->url->show ?? '#' }}" class="small-box-footer">Más informacion <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
@endsection
