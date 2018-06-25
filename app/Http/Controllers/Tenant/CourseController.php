<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\{Course, Institute, TypeCourse};
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
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Institute $institute)
    {
        $this->authorize('tenant-view', Course::class);
        $courses = Course::with('typecourse')->paginate();
        return view('tenant.course.index', compact('institute', 'courses'));
    }

    /**
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Institute $institute)
    {
        $this->authorize('tenant-create', Course::class);
        $typeCourses = TypeCourse::all();
        return view('tenant.course.create', compact('institute', 'typeCourses'));
    }

    /**
     * @param \App\Http\Requests\Tenant\StoreCourseRequest $request
     * @param \App\Institute $institute
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCourseRequest $request, Institute $institute)
    {
        $this->authorize('tenant-create', Course::class);
        return redirect()->route('tenant.courses.index', $institute)->with(['flash_success' => $request->createCourse()]);
    }

    /**
     * @param \App\Institute $institute
     * @param \App\Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Institute $institute, Course $course)
    {
        $this->authorize('tenant-update', $course);
        $typeCourses = TypeCourse::all();
        return view('tenant.course.edit', compact('institute', 'course', 'typeCourses'));
    }

    /**
     * @param \App\Http\Requests\Tenant\UpdateCourseRequest $request
     * @param \App\Institute $institute
     * @param \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCourseRequest $request,Institute $institute, Course $course)
    {
        $this->authorize('tenant-update', $course);
        return redirect()->route('tenant.courses.index', $institute)->with(['flash_success' => $request->updateCourse($course)]);
    }

    /**
     * @param \App\Institute $institute
     * @param \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Institute $institute, Course $course)
    {
        $this->authorize('tenant-delete', $course);
        $course->delete();
        return redirect()->route('tenant.courses.index', $institute)->with(['flash_success' => "Curso {$course->name} eliminado con éxito."]);
    }
}
