@extends('layouts.tenant')

@section('title', 'Inscripcion')

@section('content')
    <div class="row justify-content-center">
        <Inscription :branch-office="{{ json_encode($branchOffice) }}"></Inscription>
    </div>
@endsection