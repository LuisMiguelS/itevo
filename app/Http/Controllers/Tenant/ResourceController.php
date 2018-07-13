<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Resource};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\StoreResourceRequest;
use App\Http\Requests\Tenant\UpdateResourceRequest;

class ResourceController extends Controller
{
    /**
     * ResourceController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Resource::class);
        $resources = $branchOffice->resources()->orderByDesc('id')->paginate();
        return view('tenant.resource.index', compact('branchOffice', 'resources'));
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Resource::class);
        return view('tenant.resource.create', compact('branchOffice'));
    }

    /**
     * @param \App\Http\Requests\Tenant\StoreResourceRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreResourceRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Resource::class);
        return redirect()
            ->route('tenant.resources.index', $branchOffice)
            ->with(['flash_success' => $request->createResource($branchOffice)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Resource $resource
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Resource $resource)
    {
        $this->authorize('tenant-update', $resource);
        abort_unless($resource->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return view('tenant.resource.edit', compact('branchOffice', 'resource'));
    }

    /**
     * @param \App\Http\Requests\Tenant\UpdateResourceRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateResourceRequest $request, BranchOffice $branchOffice, Resource $resource)
    {
        $this->authorize('tenant-update', $resource);
        abort_unless($resource->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return redirect()
            ->route('tenant.resources.index', $branchOffice)
            ->with(['flash_success' => $request->updateResource($resource)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BranchOffice $branchOffice, Resource $resource)
    {
        $this->authorize('tenant-delete', $resource);
        abort_unless($resource->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $resource->delete();
        return redirect()
            ->route('tenant.resources.index', $branchOffice)
            ->with(['flash_success' => "Recurso {$resource->name} eliminado con éxito."]);
    }
}
