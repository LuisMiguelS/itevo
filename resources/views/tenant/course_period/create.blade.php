@extends('layouts.tenant')

@section('title', 'Crear curso')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
            <course_period :courses="{{ json_encode($courses) }}"
                           :classrooms="{{ json_encode($classrooms) }}"
                           :teachers="{{ json_encode($teachers) }}"
                           :coursePeriod="{{ json_encode($coursePeriod) }}"
                           :form_data="{{ json_encode([
                           'route' => route('tenant.periods.course-period.store', ['branchOffice' => $branchOffice, 'period' => $period]),
                           'method' => 'post',
                           'redirect' => route('tenant.periods.course-period.index', ['branchOffice' => $branchOffice, 'period' => $period])
                           ])}}">
            </course_period>
            @endbox

        </div>
    </div>
@endsection
