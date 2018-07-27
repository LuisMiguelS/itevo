<?php

namespace App\Http\Controllers\Tenant;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\StoreClassRoomRequest;
use App\Http\Requests\Tenant\UpdateClassRoomRequest;
use App\{
    DataTables\Tenant_Classroom_DataTable,
    DataTables\TenantClassroomDataTable,
    Http\Controllers\Controller,
    BranchOffice,
    Classroom
};

class ClassRoomController extends Controller
{
    /**
     * ClassRoomController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $title = 'Todas las aulas';
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
     * @param \App\Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BranchOffice $branchOffice, Classroom $classroom)
    {
        $this->authorize('tenant-delete', $classroom);
        abort_unless($classroom->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $classroom->delete();
        return redirect()->route('tenant.classrooms.index', $branchOffice)->with(['flash_success' => "Aula {$classroom->name} eliminada con éxito."]);
    }
}
