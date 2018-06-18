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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Institute::class);

        return view('institute.create');
    }

    /**
     * @param \App\Http\Requests\CreateInstituteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateInstituteRequest $request)
    {
        $this->authorize('create', Institute::class);

        return back()->with(['flash_success' => $request->createInstitute()]);
    }

    public function show(Institute $institute)
    {
        $this->authorize('view', Institute::class);
    }

    /**
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(institute $institute)
    {
        $this->authorize('update', $institute);

        return view('institute.edit', compact('institute'));
    }

    /**
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
     * @param \App\Institute $institute
     * @return \Illuminate\Http\RedirectResponse
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function dashboard(Institute $institute)
    {
        $this->authorize('view-dashboard', Institute::class);

        return view('admin.dashboard', compact('institute'));
    }
}
