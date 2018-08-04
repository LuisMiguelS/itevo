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
					<h3>150</h3>

					<p>New Orders</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>53<sup style="font-size: 20px">%</sup></h3>

					<p>Bounce Rate</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>44</h3>

					<p>User Registrations</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3 col-xs-6">

			<div class="small-box bg-red">
				<div class="inner">
					<h3>{{ $branchOffice->currentPromotion()->promotion_no ?? 0 }}</h3>

					<p>{{$branchOffice->currentPromotion() ? 'Promocion en transcurso' : 'No hay promocion en transcurso' }}</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="{{ $branchOffice->currentPromotion()->url->show ?? '#' }}" class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
@endsection
