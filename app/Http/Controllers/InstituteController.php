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

    public function index()
    {
        $this->authorize('view', Institute::class);

        $institutes = Institute::all();
        return view('institute.index', compact('institutes'));
    }

    public function create()
    {
        $this->authorize('create', Institute::class);

        return view('institute.create');
    }

    public function store(CreateInstituteRequest $request)
    {
        $this->authorize('create', Institute::class);

        return back()->with(['flash_success' => $request->createInstitute()]);
    }

    public function show(Institute $institute)
    {
        $this->authorize('view', Institute::class);
    }

    public function edit(institute $institute)
    {
        $this->authorize('update', $institute);

        return view('institute.edit', compact('institute'));
    }

    public function update(UpdateInstituteRequest $request, Institute $institute)
    {
        $this->authorize('update', $institute);

        return redirect()->route('institutes.index')->with(['flash_success' => $request->updateInstitute($institute)]);
    }

    public function destroy(Institute $institute)
    {
        $this->authorize('delete', $institute);

        $institute->delete();

        return back()->with(['flash_success' => "Instituto {$institute->name} eliminado con exito."]);
    }

    public function dashboard(Institute $institute)
    {
        return view('admin.dashboard', compact('institute'));
    }
}
