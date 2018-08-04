@extends('layouts.tenant')

@section('title', 'Editar curso '. $course->name)

@section('breadcrumb')
    {{ Breadcrumbs::render('course-edit', $branchOffice, $course) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
                @slot('title')
                    Editar Curso: <strong>{{ $course->name }}</strong>
                @endslot

            <form action="{{ $course->url->update }}" method="POST">
                @method('PUT')

                @include('tenant.course._fields')

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-block">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
            @endbox

        </div>
    </div>
@endsection
