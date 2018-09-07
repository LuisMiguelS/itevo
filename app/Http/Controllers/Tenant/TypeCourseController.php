<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, TypeCourse};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StoreTypeCourseRequest, UpdateTypeCourseRequest};
use App\DataTables\{TenantTypeCourseDataTable, TenantTypeCourseTrashedDataTable};

class TypeCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\TenantTypeCourseDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantTypeCourseDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', TypeCourse::class);

        $breadcrumbs = 'typeCourse';

        $title = 'Todos los tipos de cursos <a href="'. route('tenant.typeCourses.trash', $branchOffice) .'"class="btn btn-default">Papelera</a>';

        if (! auth()->user()->can('tenant-trash', TypeCourse::class)) {
            $title = 'Todos los tipos de cursos';
        }

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\DataTables\TenantTypeCourseTrashedDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trashed(TenantTypeCourseTrashedDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-trash', TypeCourse::class);

        $breadcrumbs = 'typeCourse-trash';

        $title = 'Todos los tipos de curso en la papelera';

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
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

        $typeCourse = new TypeCourse;

        return view('tenant.type_course.create', compact('branchOffice', 'typeCourse'));
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

        return redirect()
            ->route('tenant.typeCourses.index', $branchOffice)
            ->with(['flash_success' => $request->createTypeCourse($branchOffice)]);
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

        return redirect()
            ->route('tenant.typeCourses.index', $branchOffice)
            ->with(['flash_success' => $request->updateTypeCourse($typeCourse)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(BranchOffice $branchOffice, $id)
    {
        $typeCourse = TypeCourse::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-restore', $typeCourse);

        abort_unless($typeCourse->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $typeCourse->restore();

        return redirect()
            ->route('tenant.typeCourses.trash', $branchOffice)
            ->with(['flash_success' => "Tipo de curso {$typeCourse->name} restaurado con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\TypeCourse $typeCourse
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trash(BranchOffice $branchOffice, TypeCourse $typeCourse)
    {
        $this->authorize('tenant-trash', $typeCourse);

        abort_unless($typeCourse->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        abort_if($typeCourse->courses()->exists(),
            Response::HTTP_BAD_REQUEST, "No puedes eliminar el tipo de curso {$typeCourse->name}, hay informacion que depende de esta");

        $typeCourse->delete();

        return redirect()
            ->route('tenant.typeCourses.index', $branchOffice)
            ->with(['flash_success' => "Tipo de curso {$typeCourse->name} enviado a la papelera con éxito."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(BranchOffice $branchOffice, $id)
    {
        $typeCourse = TypeCourse::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $typeCourse);

        abort_unless($typeCourse->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $typeCourse->forceDelete();

        return redirect()->route('tenant.typeCourses.trash', $branchOffice)
            ->with(['flash_success' => "Tipo de curso {$typeCourse->name} eliminada con éxito."]);
    }
}
