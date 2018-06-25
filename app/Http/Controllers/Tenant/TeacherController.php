<?php

namespace App\Http\Controllers\Tenant;

use App\{Institute, Teacher};
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
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Institute $institute)
    {
        $this->authorize('tenant-view', Teacher::class);
        $teachers = $institute->teachers()->paginate();
        return view('tenant.teacher.index', compact('institute','teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Institute $institute)
    {
        $this->authorize('tenant-create', Teacher::class);
        return view('tenant.teacher.create', compact('institute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreTeacherRequest $request
     * @param \App\Institute $institute
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTeacherRequest $request, Institute $institute)
    {
        $this->authorize('tenant-create', Teacher::class);
        return redirect()
            ->route('tenant.teachers.index', $institute)
            ->with(['flash_success' => $request->createTeacher($institute)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Institute $institute
     * @param \App\Teacher $teacher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Institute $institute, Teacher $teacher)
    {
        $this->authorize('tenant-update', $teacher);
        abort_unless($teacher->isRegisteredIn($institute), Response::HTTP_NOT_FOUND);
        return view('tenant.teacher.edit', compact('institute', 'teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateTeacherRequest $request
     * @param \App\Institute $institute
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTeacherRequest $request, Institute $institute, Teacher $teacher)
    {
        $this->authorize('tenant-update', $teacher);
        abort_unless($teacher->isRegisteredIn($institute), Response::HTTP_NOT_FOUND);
        return redirect()
            ->route('tenant.teachers.index', $institute)
            ->with(['flash_success' => $request->updateTeacher($teacher)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Institute $institute
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Institute $institute, Teacher $teacher)
    {
        $this->authorize('tenant-delete', $teacher);
        abort_unless($teacher->isRegisteredIn($institute), Response::HTTP_NOT_FOUND);
        $teacher->delete();
        return redirect()
            ->route('tenant.teachers.index', $institute)
            ->with(['flash_success' => "Profesor {$teacher->full_name} eliminado con exito."]);
    }
}
