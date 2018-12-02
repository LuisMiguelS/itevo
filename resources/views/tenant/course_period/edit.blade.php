@extends('layouts.tenant')

@section('title', 'Editar curso')

@section('breadcrumb')
    {{ Breadcrumbs::render('coursePeriod-edit', $branchOffice, $period, $coursePeriod) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
            <form action="{{ $coursePeriod->url->update }}" method="post">
                @method('PUT')
                @include('tenant.course_period._fields')

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Actualizar
                        </button>
                    </div>
                </div>

            </form>
            @endbox

        </div>
    </div>
@endsection
