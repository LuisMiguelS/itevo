<?php

namespace App\Http\Controllers\Tenant;

use App\{Institute, Teacher};
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTeacherRequest;
use App\Http\Requests\Tenant\UpdateTeacherRequest;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreTeacherRequest $request
     * @param \App\Institute $institute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTeacherRequest $request, Institute $institute)
    {
        return redirect()
            ->route('tenant.teachers.index', $institute)
            ->with(['flash_success' => $request->createTeacher($institute)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Institute $institute
     * @param \App\Teacher $teacher
     * @return void
     */
    public function edit(Institute $institute, Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateTeacherRequest $request
     * @param \App\Institute $institute
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Institute $institute, Teacher $teacher)
    {
        return redirect()
            ->route('tenant.teachers.index', $institute)
            ->with(['flash_success' => $request->updateTeacher($teacher)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
