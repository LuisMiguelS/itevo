<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, TypeCourse};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
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
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', TypeCourse::class);
        $typeCourses = $branchOffice->typecourses()->paginate();
        return view('tenant.type_course.index', compact('branchOffice','typeCourses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', TypeCourse::class);
        return view('tenant.type_course.create', compact('branchOffice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreTypeCourseRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTypeCourseRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', TypeCourse::class);
        return redirect()->route('tenant.typeCourses.index', $branchOffice)->with(['flash_success' => $request->createTypeCourse($branchOffice)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, TypeCourse $typeCourse)
    {
        $this->authorize('tenant-update', $typeCourse);
        abort_unless($typeCourse->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return view('tenant.type_course.edit', compact('branchOffice','typeCourse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateTypeCourseRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTypeCourseRequest $request, BranchOffice $branchOffice, TypeCourse $typeCourse)
    {
        $this->authorize('tenant-update', $typeCourse);
        abort_unless($typeCourse->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return redirect()->route('tenant.typeCourses.index', $branchOffice)->with(['flash_success' => $request->updateTypeCourse($typeCourse)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param  \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BranchOffice $branchOffice, TypeCourse $typeCourse)
    {
        $this->authorize('tenant-delete', $typeCourse);
        abort_unless($typeCourse->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $typeCourse->delete();
        return redirect()->route('tenant.typeCourses.index', $branchOffice)->with(['flash_success' => "Tipo de curso {$typeCourse->name} eliminado con éxito."]);
    }
}
