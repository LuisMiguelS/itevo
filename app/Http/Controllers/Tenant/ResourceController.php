<?php

namespace App\Http\Controllers\Tenant;

use App\{Institute, Resource};
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreResourceRequest;
use App\Http\Requests\Tenant\UpdateResourceRequest;

class ResourceController extends Controller
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
        $this->authorize('view', Resource::class);
        $resources = Resource::paginate();
        return view('tenant.resource.index', compact('institute', 'resources'));
    }

    /**
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Institute $institute)
    {
        $this->authorize('create', Resource::class);
        return view('tenant.resource.create', compact('institute'));
    }

    /**
     * @param \App\Http\Requests\Tenant\StoreResourceRequest $request
     * @param \App\Institute $institute
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreResourceRequest $request, Institute $institute)
    {
        $this->authorize('create', Resource::class);
        return redirect()
            ->route('tenant.resources.index', $institute)
            ->with(['flash_success' => $request->createResource()]);
    }

    /**
     * @param \App\Institute $institute
     * @param \App\Resource $resource
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Institute $institute, Resource $resource)
    {
        $this->authorize('update', $resource);
        return view('tenant.resource.edit', compact('institute', 'resource'));
    }

    /**
     * @param \App\Http\Requests\Tenant\UpdateResourceRequest $request
     * @param \App\Institute $institute
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateResourceRequest $request, Institute $institute, Resource $resource)
    {
        $this->authorize('update', $resource);
        return redirect()
            ->route('tenant.resources.index', $institute)
            ->with(['flash_success' => $request->updateResource($resource)]);
    }

    /**
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Institute $institute, Resource $resource)
    {
        $this->authorize('delete', $resource);
        $resource->delete();
        return redirect()
            ->route('tenant.resources.index', $institute)
            ->with(['flash_success' => "Curso {$resource->name} eliminado con éxito."]);
    }
}
