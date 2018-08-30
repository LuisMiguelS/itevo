@extends('layouts.tenant')

@section('title', 'Inscripcion')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            @box
                @slot('title', "Inscripciones")

                <form>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estudiante <span class="text-danger">*</span></label>
                                <select class="form-control" name="#">
                                        <option value="">Estudiante</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Curso <span class="text-danger">*</span></label>
                                <select class="form-control" name="#">
                                    <option value="">Estudiante</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div>
                        Informacion del estudiante selecionado ..... <br>
                        Informacion del curso selecionado ....
                    </div>
                </form>
            @endbox

        </div>

        <div class="col-md-4">

            @box
                @slot('title', "Total a pagar")

                ... Monto del curso <br>
                ... Monto de los recurso <br>

                ... Total <br>

                <input placeholder="Monto a pagar" value="200"> <br>

                ... Devuelta <br>

                <button> Facturar</button>
            @endbox

        </div>
    </div>
@endsection