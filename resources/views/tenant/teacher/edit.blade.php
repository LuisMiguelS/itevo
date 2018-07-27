@extends('layouts.tenant')

@section('title', 'Editar profesor. '. $teacher->name)

@section('breadcrumb')
    {{ Breadcrumbs::render('teacher-edit', $branchOffice, $teacher) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-offset-2">

            @panel
                @slot('title')
                    Editar Profesor: <strong>{{ $teacher->full_name }}</strong>
                @endslot

            <form action="{{ $teacher->url->update }}" method="POST">
                @method('PUT')

                @include('tenant.teacher._fields')

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-block">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
            @endpanel

        </div>
    </div>
@endsection
