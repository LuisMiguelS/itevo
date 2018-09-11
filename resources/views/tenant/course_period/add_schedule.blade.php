@extends('layouts.tenant')

@section('title', 'Asignar horario')

@section('breadcrumb')
    {{ Breadcrumbs::render('coursePeriod-resource', $branchOffice, $period, $coursePeriod) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box

            @slot('title', 'Horarios diponibles, para asignar')

            <form action="{{ $coursePeriod->url->addSchedule }}" method="POST">
                @csrf



                <div class="form-group row">
                    <label for="abilities" class="col-sm-4 col-form-label text-md-right">Horarios</label>
                    <div class="col-md-10 row">
                        @foreach($branchOffice->schedules as $schedule)
                            <div class="custom-control custom-checkbox col-md-6">
                                <input name="schedules[{{ $schedule->id }}]"
                                       class="custom-control-input"
                                       type="checkbox"
                                       id="schedule_{{ $schedule->id }}"
                                       value="{{ $schedule->id }}"
                                        {{ old("schedules.{$schedule->id}") || in_array($schedule->id, $coursePeriod->schedules()->pluck('id', 'id')->toArray()) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="schedule_{{ $schedule->id }}">{{ "{$schedule->weekday} {$schedule->start_at->toTimeString()} - {$schedule->ends_at->toTimeString()}"  }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Actualizar
                        </button>
                    </div>
                </div>

            </form>

            @endbox

        </div>
    </div>
@endsection