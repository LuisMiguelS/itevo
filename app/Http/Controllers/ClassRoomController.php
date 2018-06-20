<?php

namespace App\Http\Controllers;

use App\{Institute, Classroom};
use App\Http\Requests\CreateClassRoomRequest;
use App\Http\Requests\UpdateClassRoomRequest;

class ClassRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Classroom::class);
        $classrooms = Classroom::paginate();
        return view('classroom.index', compact('classrooms'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Classroom::class);
        $institutes = Institute::paginate();
        return view('classroom.create', compact('institutes'));
    }

    /**
     * @param \App\Http\Requests\CreateClassRoomRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateClassRoomRequest $request)
    {
        $this->authorize('create', Classroom::class);
        return back()->with(['flash_success' => $request->createClassRoom()]);
    }

    /**
     * @param $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $this->authorize('view', Classroom::class);
    }

    /**
     * @param \App\Classroom $classroom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Classroom $classroom)
    {
        $this->authorize('update', $classroom);
        $institutes = Institute::paginate();
        return view('classroom.edit', compact('classroom', 'institutes'));
    }

    /**
     * @param \App\Http\Requests\UpdateClassRoomRequest $request
     * @param \App\Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateClassRoomRequest $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);
        return redirect()->route('classrooms.index')->with(['flash_success' => $request->updateClassRoom($classroom)]);
    }

    /**
     * @param \App\Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Classroom $classroom)
    {
        $this->authorize('delete', $classroom);
        $classroom->delete();
        return back()->with(['flash_success' => "Aula {$classroom->name} eliminada con éxito."]);
    }
}
