<?php

namespace App\Http\Controllers\Tenant;

use App\{Course, BranchOffice};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\StoreCourseRequest;
use App\Http\Requests\Tenant\UpdateCourseRequest;

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
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Course::class);
        $courses = $branchOffice->courses()->paginate();
        return view('tenant.course.index', compact('branchOffice', 'courses'));
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Course::class);
        $typeCourses = $branchOffice->typecourses;
        return view('tenant.course.create', compact('branchOffice', 'typeCourses'));
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
        return redirect()->route('tenant.courses.index', $branchOffice)->with(['flash_success' => $request->createCourse($branchOffice)]);
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
        return redirect()->route('tenant.courses.index', $branchOffice)->with(['flash_success' => $request->updateCourse($course)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BranchOffice $branchOffice, Course $course)
    {
        $this->authorize('tenant-delete', $course);
        abort_unless($course->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $course->delete();
        return redirect()->route('tenant.courses.index', $branchOffice)->with(['flash_success' => "Curso {$course->name} eliminado con éxito."]);
    }
}
