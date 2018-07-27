@extends('layouts.tenant')

@section('title', $title ?? 'Datatables')

@section('breadcrumb')
    {{ Breadcrumbs::render($breadcrumbs, $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">

            {!! $dataTable->table() !!}

        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
