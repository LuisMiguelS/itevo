<?php

namespace App\Http\Controllers\Tenant;

use App\{Institute, TypeCourse};
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTypeCourseRequest;
use App\Http\Requests\Tenant\UpdateTypeCourseRequest;

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
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Institute $institute)
    {
        $this->authorize('view', TypeCourse::class);
        $typeCourses = TypeCourse::paginate();
        return view('tenant.type_course.index', compact('institute','typeCourses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Institute $institute
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Institute $institute)
    {
        $this->authorize('create', TypeCourse::class);
        return view('tenant.type_course.create', compact('institute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreTypeCourseRequest $request
     * @param \App\Institute $institute
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTypeCourseRequest $request, Institute $institute)
    {
        $this->authorize('create', TypeCourse::class);
        return redirect()->route('tenant.typecourses.index', $institute)->with(['flash_success' => $request->createTypeCourse()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Institute $institute
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Institute $institute, TypeCourse $typeCourse)
    {
        $this->authorize('update', $typeCourse);
        return view('tenant.type_course.edit', compact('institute','typeCourse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateTypeCourseRequest $request
     * @param \App\Institute $institute
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTypeCourseRequest $request,Institute $institute, TypeCourse $typeCourse)
    {
        $this->authorize('update', $typeCourse);
        return redirect()->route('tenant.typecourses.index', $institute)->with(['flash_success' => $request->updateTypeCourse($typeCourse)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Institute $institute
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Institute $institute, TypeCourse $typeCourse)
    {
        $this->authorize('delete', $typeCourse);
        $typeCourse->delete();
        return redirect()->route('tenant.typecourses.index', $institute)->with(['flash_success' => "Tipo de curso {$typeCourse->name} eliminado con éxito."]);
    }
}
