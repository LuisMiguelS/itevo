<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\{BranchOffice, CoursePeriod, DataTables\TenantCoursePeriodDataTable, Period};
use App\Http\Requests\Tenant\{StoreCoursePeriodRequest, UpdateCoursePeriodRequest};
use Beta\B;

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
        $title = "Todos los cursos activos del periodo {$period->period_no} de la promocion {$period->promotion->promotion_no}";
        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
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
     * @param  \App\CoursePeriod  $coursePromotion
     * @return \Illuminate\Http\Response
     */
    public function show(CoursePeriod $coursePromotion)
    {
        //
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
     * Remove the specified resource from storage.
     *
     * @param  \App\CoursePeriod  $coursePromotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoursePeriod $coursePromotion)
    {
        //
    }

    protected function getCourseArray(BranchOffice $branchOffice)
    {
        return $branchOffice->courses()->get()->map(function ($values) {
            return [
                'id' => $values->id,
                'label' => "{$values->name} ({$values->typeCourse->name})"
            ];
        });
    }

    protected function getClassroomArray(BranchOffice $branchOffice)
    {
        return $branchOffice->classrooms()->get()->map(function ($values) {
            return [
                'id' => $values->id,
                'label' => "{$values->name} ({$values->building})"
            ];
        });
    }

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
