@extends('layouts.tenant')

@section('title', 'Inscripcion')

@section('content')
    <div class="row justify-content-center">
        <inscription :branch-office="{{ json_encode($branchOffice) }}"></inscription>
    </div>
@endsection