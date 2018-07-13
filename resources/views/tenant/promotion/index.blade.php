@extends('layouts.tenant')

@section('title', 'Todas las promociones')

@section('breadcrumb')
    {{ Breadcrumbs::render('promotion', $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a class="btn btn-primary btn-sm" style="color: #fff;" href="{{ route('tenant.promotions.create', $branchOffice) }}">Crear Promocion</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($promotions->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th><b>Promocion no.</b></th>
                                <th><b>Estado</b></th>
                                <th><b>Fecha de Creación</b></th>
                                <th><b>Fecha de Modificacion</b></th>
                                <th><b>Aciones</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($promotions  as $promotion)
                                <tr>
                                    <th>{{ "No. {$promotion->promotion_no}" }}</th>
                                    <th>{{ $promotion->status }}</th>
                                    <th>{{ $promotion->created_at->format('Y-m-d') }}</th>
                                    <th>{{ $promotion->updated_at->format('Y-m-d') }}</th>
                                    <th>
                                        @can('tenant-change-status', $promotion)
                                            <a class="btn btn-default btn-xs"
                                               href="{{ $promotion->url->status }}"
                                               @if($promotion->status === \App\Promotion::STATUS_FINISHED)
                                                    style="display: none"
                                               @endif
                                               onclick="event.preventDefault();
                                                       document.getElementById('promotion-status-{{$promotion->id}}').submit();">
                                                Finalizar
                                            </a>
                                            <form id="promotion-status-{{$promotion->id}}" action="{{ $promotion->url->status }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endcan


                                        <a class="btn btn-primary btn-xs" href="{{ $promotion->url->show }}">
                                            Ver detalles
                                        </a>

                                        @can('tenant-update', $promotion)
                                            <a class="btn btn-info btn-xs" href="{{ $promotion->url->edit }}">
                                                Editar
                                            </a>
                                        @endcan


                                        @can('tenant-delete', $promotion)
                                            <a class="btn btn-danger btn-xs" href="{{ $promotion->url->delete }}"
                                               onclick="event.preventDefault();
                                                       document.getElementById('promotion-delete-{{$promotion->id}}').submit();">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form id="promotion-delete-{{$promotion->id}}" action="{{ $promotion->url->delete }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endcan
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $promotions->links() }}
                    @else
                        <div class="alert alert-info" role="alert">
                            No hay promociones registradas
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
