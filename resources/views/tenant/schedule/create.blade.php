@extends('layouts.tenant')

@section('title', 'Crear horario')

@section('breadcrumb')
    {{ Breadcrumbs::render('schedule-create', $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
                @slot('title', "Crear horario")

                <form action="{{ route('tenant.schedules.store', $branchOffice) }}" method="POST">

                    @include('tenant.schedule._fields')

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            @endbox

        </div>
    </div>
@endsection
