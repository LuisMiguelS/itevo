@extends('layouts.app')

 @section('content')
     <section class="content-header">
         <h1 style="text-align: center">Sucursales</h1>
     </section>

     <section class="content">
         <div class="row">
             <div class="col-sm-6 col-sm-offset-3">
                 <div class="box box-solid">
                     <div class="box-header with-border">
                         <h3 class="box-title">Sucursales a las que puedes acceder</h3>

                         <div class="box-tools">
                             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                             </button>
                         </div>
                     </div>
                     <div class="box-body no-padding">
                         <ul class="nav nav-pills nav-stacked">
                             @forelse($branchOffices as $branchOffice)
                                 <li><a href="{{ route('tenant.dashboard', $branchOffice) }}"><i class="fa fa-filter"></i> {{ $branchOffice->name }} </a></li>
                             @empty
                                 <li><a href="#"><i class="fa fa-filter"></i> No tienes una sucursal asignada... </a></li>
                             @endforelse
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </section>
@endsection
