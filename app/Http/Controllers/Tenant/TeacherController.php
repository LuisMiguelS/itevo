<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Teacher};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StoreTeacherRequest, UpdateTeacherRequest};
use App\DataTables\{TenantTeacherDataTable, TenantTeacherTrashedDataTable};

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

        $title = 'Todos los profesores <a href="'. route('tenant.teachers.trash', $branchOffice) .'"class="btn btn-default">Papelera</a>';

        if (! auth()->user()->can('tenant-trash', Teacher::class)) {
            $title = 'Todos los profesores';
        }

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    public function trashed(TenantTeacherTrashedDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-trash', Teacher::class);

        $breadcrumbs = 'teacher-trash';

        $title = 'Todos los profesores en la papelera';

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

    public function restore(BranchOffice $branchOffice, $id)
    {
        $teacher = Teacher::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-restore', $teacher);

        abort_unless($teacher->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $teacher->restore();

        return redirect()
            ->route('tenant.teachers.trash', $branchOffice)
            ->with(['flash_success' => "Profesor {$teacher->full_name} restaurado con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trash(BranchOffice $branchOffice, Teacher $teacher)
    {
        $this->authorize('tenant-trash', $teacher);

        abort_unless($teacher->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        abort_if($teacher->coursePeriod()->exists(),
            Response::HTTP_BAD_REQUEST, "No puedes eliminar el profesor {$teacher->full_name}, hay informacion que depende de esta");

        $teacher->delete();

        return redirect()
            ->route('tenant.teachers.index', $branchOffice)
            ->with(['flash_success' => "Profesor {$teacher->full_name} enviado a la papelera con éxito."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(BranchOffice $branchOffice, $id)
    {
        $teacher = Teacher::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $teacher);

        abort_unless($teacher->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $teacher->forceDelete();

        return redirect()
            ->route('tenant.teachers.trash', $branchOffice)
            ->with(['flash_success' => "Profesor {$teacher->full_name} eliminado con exito."]);
    }
}
