<?php

namespace App\Http\Controllers;

use App\Institute;
use App\Http\Requests\UpdateInstituteRequest;
use App\Http\Requests\CreateInstituteRequest;

class InstituteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Institute::class);

        $institutes = Institute::all();
        return view('institute.index', compact('institutes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Institute::class);

        return view('institute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateInstituteRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateInstituteRequest $request)
    {
        $this->authorize('create', Institute::class);

        return back()->with(['flash_success' => $request->createInstitute()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Institute $institute)
    {
        $this->authorize('view', Institute::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Institute $institute
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(institute $institute)
    {
        $this->authorize('update', $institute);

        return view('institute.edit', compact('institute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateInstituteRequest $request
     * @param \App\Institute $institute
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateInstituteRequest $request, Institute $institute)
    {
        $this->authorize('update', $institute);

        return redirect()->route('institutes.index')->with(['flash_success' => $request->updateInstitute($institute)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Institute $institute
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Institute $institute)
    {
        $this->authorize('delete', $institute);

        $institute->delete();

        return back()->with(['flash_success' => "Instituto {$institute->name} eliminado con exito."]);
    }

    /**
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(Institute $institute)
    {
        return view('admin.dashboard', compact('institute'));
    }
}
