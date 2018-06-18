<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view', Course::class);
        
        $courses = Course::all();

        return view('course.index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        return view('course.create');
    }

    public function store(CreateCourseRequest $request)
    {
        $this->authorize('create', Course::class);

        return back()->with(['flash_success' => $request->createCourse()]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        return view('course.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        return redirect()->route('courses.index')->with(['flash_success' => $request->updateCourse($course)]);
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return back()->with(['flash_success' => "Curso {$course->name} eliminado con éxito."]);
    }
}
