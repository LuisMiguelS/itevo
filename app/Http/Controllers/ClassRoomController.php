<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Http\Requests\CreateClassRoomRequest;
use App\Http\Requests\UpdateClassRoomRequest;

class ClassRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view', Classroom::class);
        
        $classrooms = Classroom::all();

        return view('classroom.index', compact('classrooms'));
    }

    public function create()
    {
        $this->authorize('create', Classroom::class);

        return view('classroom.create');
    }

    public function store(CreateClassRoomRequest $request)
    {
        $this->authorize('create', Classroom::class);

        return back()->with(['flash_success' => $request->createClassRoom()]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        return view('classroom.edit', compact('classroom'));
    }

    public function update(UpdateClassRoomRequest $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        return redirect()->route('classrooms.index')->with(['flash_success' => $request->updateClassRoom($classroom)]);
    }

    public function destroy(Classroom $classroom)
    {
        $this->authorize('delete', $classroom);

        $classroom->delete();

        return back()->with(['flash_success' => "Aula {$classroom->name} eliminada con éxito."]);
    }
}
