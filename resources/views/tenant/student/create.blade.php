@extends('layouts.tenant')

@section('title', 'Crear estudiante')

@section('breadcrumb')
    {{ Breadcrumbs::render('student-create', $branchOffice) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">
            @box
            @slot('title', 'Crear estudiante')

                <form action="{{ route('tenant.students.store', $branchOffice) }}" method="POST">

                    @include('tenant.student._fields')

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

@push('scripts')

@endpush
