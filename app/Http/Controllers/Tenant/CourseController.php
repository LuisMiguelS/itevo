<?php

namespace App\Http\Controllers\Tenant;

use App\{Course, BranchOffice};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StoreCourseRequest, UpdateCourseRequest};
use App\DataTables\{TenantCourseDataTable, TenantCourseTrashedDataTable};

class CourseController extends Controller
{
    /**
     * CourseController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \App\DataTables\TenantCourseDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantCourseDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Course::class);

        $breadcrumbs = 'course';

        $title = 'Todos los cursos <a href="'. route('tenant.courses.trash', $branchOffice) .'"class="btn btn-default">Papelera</a>';

        if (! auth()->user()->can('tenant-trash', Course::class)) {
            $title = 'Todos los cursos';
        }

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\DataTables\TenantCourseTrashedDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trashed(TenantCourseTrashedDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-trash', Course::class);

        $breadcrumbs = 'course-trash';

        $title = 'Todos los cursos en la papelera <a href="'. route('tenant.courses.index', $branchOffice) .'"class="btn btn-default">Cursos</a>';

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Course::class);

        $typeCourses = $branchOffice->typecourses()->orderByDesc('id')->paginate();

        $course = new Course;

        return view('tenant.course.create', compact('branchOffice', 'typeCourses', 'course'));
    }

    /**
     * @param \App\Http\Requests\Tenant\StoreCourseRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCourseRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Course::class);

        return redirect()
            ->route('tenant.courses.index', $branchOffice)
            ->with(['flash_success' => $request->createCourse($branchOffice)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Course $course)
    {
        $this->authorize('tenant-update', $course);

        abort_unless($course->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $typeCourses = $branchOffice->typecourses;

        return view('tenant.course.edit', compact('branchOffice', 'course', 'typeCourses'));
    }

    /**
     * @param \App\Http\Requests\Tenant\UpdateCourseRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCourseRequest $request, BranchOffice $branchOffice, Course $course)
    {
        $this->authorize('tenant-update', $course);

        abort_unless($course->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        return redirect()
            ->route('tenant.courses.index', $branchOffice)
            ->with(['flash_success' => $request->updateCourse($course)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(BranchOffice $branchOffice, $id)
    {
        $course = Course::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-restore', $course);

        abort_unless($course->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $course->restore();

        return redirect()
            ->route('tenant.courses.trash', $branchOffice)
            ->with(['flash_success' => "Curso {$course->name} restaurada con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trash(BranchOffice $branchOffice, Course $course)
    {
        $this->authorize('tenant-trash', $course);

        abort_unless($course->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        abort_if($course->coursePeriod()->exists(),
            Response::HTTP_BAD_REQUEST, "No puedes eliminar el Curso {$course->name}, hay informacion que depende de esta");

        $course->delete();

        return redirect()
            ->route('tenant.courses.index', $branchOffice)
            ->with(['flash_success' => "Curso {$course->name} enviado a la papelera con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(BranchOffice $branchOffice, $id)
    {
        $course = Course::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $course);

        abort_unless($course->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $course->forceDelete();

        return redirect()
            ->route('tenant.courses.trash', $branchOffice)
            ->with(['flash_success' => "Curso {$course->name} eliminado con éxito."]);
    }
}
