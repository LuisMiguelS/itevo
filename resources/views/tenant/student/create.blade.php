@extends('layouts.tenant')

@section('title', 'Crear profesor')

@section('breadcrumb')
    {{ Breadcrumbs::render('student-create', $branchOffice) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">
            @box
            <form action="{{ route('tenant.students.store', $branchOffice) }}" method="POST">

                @include('tenant.student._fileds')

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
