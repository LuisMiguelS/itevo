@extends('layouts.tenant')

@section('title', 'Crear profesor')

@section('breadcrumb')
    {{ Breadcrumbs::render('teacher-create', $branchOffice) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        Llena los campos requeridos: <span class="text-danger"><strong>*</strong></span>
                    </div>
                </div>

                <div class="panel-body">
                    <form action="{{ route('tenant.teachers.store', $branchOffice) }}" method="POST">

                        @include('tenant.teacher._fields')

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
