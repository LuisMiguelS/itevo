<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\{StoreCoursePeriodRequest, UpdateCoursePeriodRequest};
use App\{BranchOffice, CoursePeriod, DataTables\TenantCoursePeriodDataTable, Period};

class CoursePeriodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\TenantCoursePeriodDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantCoursePeriodDataTable $dataTable, BranchOffice $branchOffice, Period $period)
    {
        $this->authorize('tenant-view', CoursePeriod::class);

        $breadcrumbs = 'coursePeriod';

        $title = "Todos los cursos activos del periodo {$period->period_no} de la promocion no. {$period->promotion->promotion_no}";

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'period', 'breadcrumbs', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice, Period $period)
    {
        $this->authorize('tenant-create', CoursePeriod::class);

        $courses = $this->getCourseArray($branchOffice);

        $classrooms = $this->getClassroomArray($branchOffice);

        $teachers = $this->getTeacherArray($branchOffice);

        $coursePeriod = new CoursePeriod;

        return view('tenant.course_period.create', compact('branchOffice', 'period', 'courses', 'classrooms', 'teachers', 'coursePeriod'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreCoursePeriodRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCoursePeriodRequest $request, BranchOffice $branchOffice, Period $period)
    {
        $this->authorize('tenant-create', CoursePeriod::class);

        return redirect()
            ->route('tenant.periods.course-period.index', [
                'branchOffice' => $branchOffice,
                'period' => $period
            ])
            ->with(['flash_success' => $request->createCoursePromotion($period)]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @return void
     */
    public function show(BranchOffice $branchOffice, Period $period)
    {
        dd("Horario");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @param \App\CoursePeriod $coursePeriod
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod)
    {
        $this->authorize('tenant-update', $coursePeriod);

        $courses = $this->getCourseArray($branchOffice);

        $classrooms = $this->getClassroomArray($branchOffice);

        $teachers = $this->getTeacherArray($branchOffice);

        $coursePeriod->load('course', 'teacher', 'classroom');

        return view('tenant.course_period.edit', compact('branchOffice', 'period', 'courses', 'classrooms', 'teachers', 'coursePeriod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateCoursePeriodRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @param \App\CoursePeriod $coursePeriod
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCoursePeriodRequest $request, BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod)
    {
        $this->authorize('tenant-update', $coursePeriod);

        return redirect()->route('tenant.periods.course-period.index', [
            'branchOffice' => $branchOffice,
            'period' => $period
        ])->with(['flash_success' => $request->updateCoursePeriod($coursePeriod)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @param \App\CoursePeriod $coursePeriod
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function resource(BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod)
    {
        $this->authorize('tenant-addResource', $coursePeriod);

        return view('tenant.course_period.add_resource', compact('branchOffice','period', 'coursePeriod'));
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @param \App\CoursePeriod $coursePeriod
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function addResource(BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod)
    {
        $this->authorize('tenant-addResource', $coursePeriod);

        if (request('resources') === null){
            $coursePeriod->resources()->detach();

            return back();
        }

        $coursePeriod->addResources(request('resources'));

        return redirect()->route('tenant.periods.course-period.resources.index', [
            'branchOffice' => $branchOffice,
            'period' => $period,
            'coursePeriod' => $coursePeriod
        ])->with(['flash_success' => 'Recursos actualizados con éxito para el curso del periodo actual']);
    }

    public function schedule(BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod)
    {
        $this->authorize('tenant-addSchedule', $coursePeriod);

        return view('tenant.course_period.add_schedule', compact('branchOffice','period', 'coursePeriod'));
    }

    public function addSchedule(BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod)
    {
        $this->authorize('tenant-addSchedule', $coursePeriod);

        if (request('schedules') === null){
            $coursePeriod->schedules()->detach();

            return back();
        }

        $coursePeriod->addSchedules(request('schedules'));

        return redirect()->route('tenant.periods.course-period.schedules.index', [
            'branchOffice' => $branchOffice,
            'period' => $period,
            'coursePeriod' => $coursePeriod
        ])->with(['flash_success' => 'Recursos actualizados con éxito para el curso del periodo actual']);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    protected function getCourseArray(BranchOffice $branchOffice)
    {
        return $branchOffice->courses()->get()->map(function ($values) {
            return [
                'id' => $values->id,
                'label' => "{$values->name} ({$values->typeCourse->name})"
            ];
        });
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    protected function getClassroomArray(BranchOffice $branchOffice)
    {
        return $branchOffice->classrooms()->get()->map(function ($values) {
            return [
                'id' => $values->id,
                'label' => "{$values->name} ({$values->building})"
            ];
        });
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    protected function getTeacherArray(BranchOffice $branchOffice)
    {
        return $branchOffice->teachers()->get()->map(function ($values) {
            return [
                'id' => $values->id,
                'label' => "{$values->name} {$values->last_name}"
            ];
        });
    }
}
