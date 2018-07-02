<?php

namespace App\Http\Controllers;

use App\BranchOffice;
use App\Http\Requests\UpdateBranchOfficeRequest;
use App\Http\Requests\CreateBranchOfficeRequest;

class BranchOfficeController extends Controller
{
    /**
     * BranchOfficeController constructor.
     */
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
        $this->authorize('view', BranchOffice::class);
        $branchOffices = BranchOffice::paginate();
        return view('branch_office.index', compact('branchOffices'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', BranchOffice::class);
        return view('branch_office.create');
    }

    /**
     * @param \App\Http\Requests\CreateBranchOfficeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateBranchOfficeRequest $request)
    {
        $this->authorize('create', BranchOffice::class);
        return redirect()
            ->route('branchOffices.index')
            ->with(['flash_success' => $request->createBranchOffice()]);
    }


    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice)
    {
        $this->authorize('update', $branchOffice);
        return view('branch_office.edit', compact('branchOffice'));
    }

    /**
     * @param \App\Http\Requests\UpdateBranchOfficeRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateBranchOfficeRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('update', $branchOffice);
        return redirect()
            ->route('branchOffices.index')
            ->with(['flash_success' => $request->updateBranchOffice($branchOffice)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BranchOffice $branchOffice)
    {
        $this->authorize('delete', $branchOffice);
        $branchOffice->delete();
        return back()->with(['flash_success' => "Sucursal {$branchOffice->name} eliminado con exito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function dashboard(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', BranchOffice::class);
        return view('tenant.dashboard', compact('branchOffice'));
    }
}
