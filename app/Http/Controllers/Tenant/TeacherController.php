<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, DataTables\TenantTeacherDataTable, Teacher};
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTeacherRequest;
use App\Http\Requests\Tenant\UpdateTeacherRequest;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends Controller
{
    /**
     * TeacherController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\TenantTeacherDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantTeacherDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Teacher::class);
        $breadcrumbs = 'teacher';
        $title = 'Todos los Profesores';
        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Teacher::class);
        $teacher = new Teacher;
        return view('tenant.teacher.create', compact('branchOffice', 'teacher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreTeacherRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTeacherRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Teacher::class);
        return redirect()
            ->route('tenant.teachers.index', $branchOffice)
            ->with(['flash_success' => $request->createTeacher($branchOffice)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Teacher $teacher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Teacher $teacher)
    {
        $this->authorize('tenant-update', $teacher);
        abort_unless($teacher->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return view('tenant.teacher.edit', compact('branchOffice', 'teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateTeacherRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTeacherRequest $request, BranchOffice $branchOffice, Teacher $teacher)
    {
        $this->authorize('tenant-update', $teacher);
        abort_unless($teacher->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return redirect()
            ->route('tenant.teachers.index', $branchOffice)
            ->with(['flash_success' => $request->updateTeacher($teacher)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BranchOffice $branchOffice, Teacher $teacher)
    {
        $this->authorize('tenant-delete', $teacher);
        abort_unless($teacher->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $teacher->delete();
        return redirect()
            ->route('tenant.teachers.index', $branchOffice)
            ->with(['flash_success' => "Profesor {$teacher->full_name} eliminado con exito."]);
    }
}
