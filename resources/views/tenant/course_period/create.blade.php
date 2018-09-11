@extends('layouts.tenant')

@section('title', 'Crear curso')

@section('breadcrumb')
    {{ Breadcrumbs::render('coursePeriod-create', $branchOffice, $period) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
                @slot('title', "Crear un nuevo curso (activo) para el periodo {$period->period_no}")

                <form action="{{ route('tenant.periods.course-period.store', ['branchOffice' => $branchOffice, 'period' => $period]) }}" method="post">

                    @include('tenant.course_period._fields')

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
