<?php

namespace App\Http\Controllers;

use App\TypeCourse;
use App\Http\Requests\UpdateTypeCourseRequest;
use App\Http\Requests\CreateTypeCourseRequest;

class TypeCourseController extends Controller
{
    /**
     * TypeCourseController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', TypeCourse::class);
        $typeCourses = TypeCourse::paginate();
        return view('type_course.index', compact('typeCourses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', TypeCourse::class);
        return view('type_course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateTypeCourseRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateTypeCourseRequest $request)
    {
        $this->authorize('create', TypeCourse::class);
        return back()->with(['flash_success' => $request->createTypeCourse()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(TypeCourse $typeCourse)
    {
        $this->authorize('view', $typeCourse);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(TypeCourse $typeCourse)
    {
        $this->authorize('update', $typeCourse);
        return view('type_course.edit', compact('typeCourse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTypeCourseRequest $request
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTypeCourseRequest $request, TypeCourse $typeCourse)
    {
        $this->authorize('update', $typeCourse);
        return redirect()->route('typecourses.index')->with(['flash_success' => $request->updateTypeCourse($typeCourse)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(TypeCourse $typeCourse)
    {
        $this->authorize('delete', $typeCourse);
        $typeCourse->delete();
        return back()->with(['flash_success' => "Tipo de curso {$typeCourse->name} eliminado con éxito."]);
    }
}
