@extends('layouts.tenant')

@section('title', 'Editar estudiante '. $student->name)

@section('breadcrumb')
    {{ Breadcrumbs::render('student-edit', $branchOffice, $student) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
            @slot('title')
                Editar estudiante: <strong>{{ $student->name }}</strong>
            @endslot

            <form action="{{ $student->url->update }}" method="POST">
                @method('PUT')

                @include('tenant.student._fields')

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
