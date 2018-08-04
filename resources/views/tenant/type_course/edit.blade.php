@extends('layouts.tenant')

@section('title', 'Editar tipo de recurso '. $typeCourse->name)

@section('breadcrumb')
    {{ Breadcrumbs::render('typeCourse-edit', $branchOffice, $typeCourse) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
                @slot('title')
                    Editar Tipo de Curso: <strong>{{ $typeCourse->name }}</strong>
                @endslot

                <form action="{{ $typeCourse->url->update }}" method="POST">
                    @method('PUT')

                    @include('tenant.type_course._fields')

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
