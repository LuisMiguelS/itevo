@extends('layouts.tenant')

@section('title', "Editar horario {$schedule->start_at->format('h:i:s A')} - {$schedule->ends_at->format('h:i:s A')}")

@section('breadcrumb')
    {{ Breadcrumbs::render('schedule-edit', $branchOffice, $schedule) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
            @slot('title', "Editar horario {$schedule->start_at->format('h:i:s A')} - {$schedule->ends_at->format('h:i:s A')}")

            <form action="{{ $schedule->url->update }}" method="POST">
                @method('PUT')

                @include('tenant.schedule._fields')

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
