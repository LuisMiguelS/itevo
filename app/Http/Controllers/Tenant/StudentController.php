<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Student};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StoreStudentRequest, UpdateStudentRequest};
use App\DataTables\{TenantStudentDataTable, TenantStudentTrashedDataTable};

class StudentController extends Controller
{
    /**
     * StudentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\TenantStudentDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantStudentDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Student::class);

        $breadcrumbs = 'student';

        $title = 'Todos los estudiantes <a href="'. route('tenant.students.trash', $branchOffice) .'"class="btn btn-default">Papelera</a>';

        if (! auth()->user()->can('tenant-trash', Student::class)) {
            $title = 'Todos los estudiantes';
        }

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\DataTables\TenantStudentTrashedDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trashed(TenantStudentTrashedDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-trash', Student::class);

        $breadcrumbs = 'student-trash';

        $title = 'Todos los estudiantes en la papelera';

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
        $this->authorize('tenant-create', Student::class);

        $student = new Student;

        return view('tenant.student.create', compact('branchOffice', 'student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreStudentRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreStudentRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Student::class);

        return redirect()
            ->route('tenant.students.index', $branchOffice)
            ->with(['flash_success' => $request->createStudent($branchOffice)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Student $student)
    {
        $this->authorize('tenant-update', $student);

        abort_unless($student->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        return view('tenant.student.edit', compact('branchOffice', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateStudentRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param  \App\Student $student
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateStudentRequest $request, BranchOffice $branchOffice, Student $student)
    {
        $this->authorize('tenant-update', $student);

        abort_unless($student->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        return redirect()
            ->route('tenant.students.index', $branchOffice)
            ->with(['flash_success' => $request->updateStudent($student)]);
    }


    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(BranchOffice $branchOffice, $id)
    {
        $student = Student::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $student);

        abort_unless($student->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $student->restore();

        return redirect()
            ->route('tenant.students.trash', $branchOffice)
            ->with(['flash_success' => "Estudiante {$student->full_name} restaurado con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Student $student
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trash(BranchOffice $branchOffice, Student $student)
    {
        $this->authorize('tenant-trash', $student);

        abort_if($student->coursePeriod()->exists(),
            Response::HTTP_BAD_REQUEST,
            "No puedes eliminar el estudiante {$student->full_name}, hay informacion que depende de esta");

        abort_unless($student->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $student->delete();

        return redirect()
            ->route('tenant.students.index', $branchOffice)
            ->with(['flash_success' => "Estudiante {$student->full_name} enviado a la papelera con éxito."]);
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
        $student = Student::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $student);

        abort_unless($student->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $student->forceDelete();

        return redirect()
            ->route('tenant.students.trash', $branchOffice)
            ->with(['flash_success' => "Estudiante {$student->full_name} eliminado con exito."]);
    }
}
