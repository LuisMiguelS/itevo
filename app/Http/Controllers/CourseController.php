<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\TypeCourse;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Course::class);
        $courses = Course::with('typecourse')->paginate();
        return view('course.index', compact('courses'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Course::class);
        $typeCourses = TypeCourse::all();
        return view('course.create', compact('typeCourses'));
    }

    /**
     * @param \App\Http\Requests\CreateCourseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        return back()->with(['flash_success' => $request->createCourse()]);
    }

    /**
     * @param $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $this->authorize('view', Course::class);
    }

    /**
     * @param \App\Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        $typeCourses = TypeCourse::all();
        return view('course.edit', compact('course', 'typeCourses'));
    }

    /**
     * @param \App\Http\Requests\UpdateCourseRequest $request
     * @param \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);
        return redirect()->route('courses.index')->with(['flash_success' => $request->updateCourse($course)]);
    }

    /**
     * @param \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();
        return back()->with(['flash_success' => "Curso {$course->name} eliminado con éxito."]);
    }
}
