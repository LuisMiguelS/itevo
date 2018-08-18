@extends('layouts.tenant')

@section('title', 'Editar curso')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
            <course_period :courses="{{ json_encode($courses) }}"
                           :classrooms="{{ json_encode($classrooms)}}"
                           :teachers="{{ json_encode($teachers)}}"
                           :course-period="{{ json_encode($coursePeriod) }}"
                           :form_data="{{ json_encode([
                           'route' => route('tenant.periods.course-period.update', ['branchOffice' => $branchOffice, 'period' => $period, 'coursePeriod' => $coursePeriod]),
                           'method' => 'put',
                           'redirect' => route('tenant.periods.course-period.index', ['branchOffice' => $branchOffice, 'period' => $period])
                           ])}}">
            </course_period>
            @endbox

        </div>
    </div>
@endsection
