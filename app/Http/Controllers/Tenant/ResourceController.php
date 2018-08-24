<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Resource};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StoreResourceRequest, UpdateResourceRequest};
use App\DataTables\{TenantResourceDataTable, TenantResourceTrashedDataTable};

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
     * @param \App\DataTables\TenantResourceDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantResourceDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Resource::class);

        $breadcrumbs = 'resource';

        $title = 'Todos los recursos <a href="'. route('tenant.resources.trash', $branchOffice) .'"class="btn btn-default">Papelera</a>';

        if (! auth()->user()->can('tenant-trash', Resource::class)) {
            $title = 'Todos los recursos';
        }

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\DataTables\TenantResourceTrashedDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trashed(TenantResourceTrashedDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-trash', Resource::class);

        $breadcrumbs = 'resource-trash';

        $title = 'Todos los recursos en la papelera';

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Resource::class);

        $resource = new Resource;

        return view('tenant.resource.create', compact('branchOffice', 'resource'));
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(BranchOffice $branchOffice, $id)
    {
        $resource = Resource::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $resource);

        abort_unless($resource->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $resource->restore();

        return redirect()
            ->route('tenant.resources.trash', $branchOffice)
            ->with(['flash_success' => "Recurso {$resource->name} restaurada con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trash(BranchOffice $branchOffice, Resource $resource)
    {
        $this->authorize('tenant-trash', $resource);

        abort_if($resource->coursePeriod()->exists(),
            Response::HTTP_BAD_REQUEST,
            "No puedes eliminar el recurso {$resource->name}, hay informacion que depende de esta");

        abort_unless($resource->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $resource->delete();

        return redirect()
            ->route('tenant.resources.index', $branchOffice)
            ->with(['flash_success' => "Recurso {$resource->name} enviado a la papelera con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(BranchOffice $branchOffice, $id)
    {
        $resource = Resource::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $resource);

        abort_unless($resource->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $resource->forceDelete();

        return redirect()
            ->route('tenant.resources.trash', $branchOffice)
            ->with(['flash_success' => "Recurso {$resource->name} eliminada con éxito."]);
    }
}
