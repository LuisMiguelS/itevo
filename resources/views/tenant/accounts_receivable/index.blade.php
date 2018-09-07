@extends('layouts.tenant')

@section('title', 'Cuentas por cobrar')

@section('content')
    <div class="row justify-content-center">
        <accounts-receivable :branch-office="{{ json_encode($branchOffice) }}"></accounts-receivable>
    </div>
@endsection