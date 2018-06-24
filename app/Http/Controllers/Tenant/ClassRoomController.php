<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Requests\Tenant\StoreClassRoomRequest;
use App\Http\Requests\Tenant\UpdateClassRoomRequest;
use App\{Http\Controllers\Controller, Institute, Classroom};

class ClassRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Institute $institute)
    {
        $this->authorize('tenant-view', Classroom::class);
        $classrooms = Classroom::onlyRelations($institute)->paginate();
        return view('tenant.classroom.index', compact('institute','classrooms'));
    }

    /**
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Institute $institute)
    {
        $this->authorize('tenant-create', Classroom::class);
        return view('tenant.classroom.create', compact('institute'));
    }

    /**
     * @param \App\Http\Requests\Tenant\StoreClassRoomRequest $request
     * @param \App\Institute $institute
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreClassRoomRequest $request, Institute $institute)
    {
        $this->authorize('tenant-create', Classroom::class);
        return redirect()->route('tenant.classrooms.index' , $institute)->with(['flash_success' => $request->createClassRoom($institute)]);
    }

    /**
     * @param \App\Institute $institute
     * @param \App\Classroom $classroom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Institute $institute, Classroom $classroom)
    {
        $this->authorize('tenant-update', $classroom);
        return view('tenant.classroom.edit', compact('institute', 'classroom'));
    }

    /**
     * @param \App\Http\Requests\Tenant\UpdateClassRoomRequest $request
     * @param \App\Institute $institute
     * @param \App\Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateClassRoomRequest $request,Institute $institute, Classroom $classroom)
    {
        $this->authorize('tenant-update', $classroom);
        return redirect()->route('tenant.classrooms.index', $institute)->with(['flash_success' => $request->updateClassRoom($classroom)]);
    }

    /**
     * @param \App\Institute $institute
     * @param \App\Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Institute $institute, Classroom $classroom)
    {
        $this->authorize('tenant-delete', $classroom);
        $classroom->delete();
        return redirect()->route('tenant.classrooms.index', $institute)->with(['flash_success' => "Aula {$classroom->name} eliminada con éxito."]);
    }
}