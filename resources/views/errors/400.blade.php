@extends('errors.Custom-layout')

@section('code', '400')

@section('title', __('Solicitud incorrecta'))

@section('image')
    <div style="background-image: url('/svg/400.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@endsection

@section('message', $exception->getMessage())

@section('btn-url', 'javascript:history.back()')
@section('btn-text', 'Regresa')