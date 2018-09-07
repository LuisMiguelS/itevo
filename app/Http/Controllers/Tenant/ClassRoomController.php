<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Classroom};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StoreClassRoomRequest, UpdateClassRoomRequest};
use App\DataTables\{TenantClassroomDataTable, TenantClassroomTrashedDataTable};

class ClassRoomController extends Controller
{
    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\DataTables\TenantClassroomDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantClassroomDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Classroom::class);

        $breadcrumbs = 'classroom';

        $title = 'Todas las aulas <a href="'. route('tenant.classrooms.trash', $branchOffice) .'"class="btn btn-default">Papelera</a>';

        if (! auth()->user()->can('tenant-trash', Classroom::class)) {
            $title = 'Todas las aulas';
        }

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\DataTables\TenantClassroomTrashedDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trashed(TenantClassroomTrashedDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-trash', Classroom::class);

        $breadcrumbs = 'classroom-trash';

        $title = 'Todas las aulas en la papelera';

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Classroom::class);

        $classroom = new Classroom;

        return view('tenant.classroom.create', compact('branchOffice', 'classroom'));
    }

    /**
     * @param \App\Http\Requests\Tenant\StoreClassRoomRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreClassRoomRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Classroom::class);

        return redirect()->route('tenant.classrooms.index' , $branchOffice)->with(['flash_success' => $request->createClassRoom($branchOffice)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Classroom $classroom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Classroom $classroom)
    {
        $this->authorize('tenant-update', $classroom);

        abort_unless($classroom->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        return view('tenant.classroom.edit', compact('branchOffice', 'classroom'));
    }

    /**
     * @param \App\Http\Requests\Tenant\UpdateClassRoomRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateClassRoomRequest $request,BranchOffice $branchOffice, Classroom $classroom)
    {
        $this->authorize('tenant-update', $classroom);

        abort_unless($classroom->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        return redirect()->route('tenant.classrooms.index', $branchOffice)->with(['flash_success' => $request->updateClassRoom($classroom)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(BranchOffice $branchOffice, $id)
    {
        $classroom = Classroom::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-restore', $classroom);

        abort_unless($classroom->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $classroom->restore();

        return redirect()->route('tenant.classrooms.trash', $branchOffice)->with(['flash_success' => "Aula {$classroom->name} restaurada con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trash(BranchOffice $branchOffice, Classroom $classroom)
    {
        $this->authorize('tenant-trash', $classroom);

        abort_unless($classroom->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        abort_if($classroom->coursePeriod()->exists(),
            Response::HTTP_BAD_REQUEST, "No puedes eliminar el aula {$classroom->name}, hay informacion que depende de esta");

        $classroom->delete();

        return redirect()
            ->route('tenant.classrooms.index', $branchOffice)
            ->with(['flash_success' => "Aula {$classroom->name} enviado a la papelera con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(BranchOffice $branchOffice, $id)
    {
        $classroom = Classroom::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $classroom);

        abort_unless($classroom->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $classroom->forceDelete();

        return redirect()
            ->route('tenant.classrooms.trash', $branchOffice)
            ->with(['flash_success' => "Aula {$classroom->name} eliminada con éxito."]);
    }
}
