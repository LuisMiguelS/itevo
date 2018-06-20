<?php

namespace App\Http\Controllers;

use App\Resource;
use App\Http\Requests\CreateResourceRequest;
use App\Http\Requests\UpdateResourceRequest;

class ResourceController extends Controller
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
        $this->authorize('view', Resource::class);
        $resources = Resource::paginate();
        return view('resource.index', compact('resources'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Resource::class);
        return view('resource.create');
    }

    /**
     * @param \App\Http\Requests\CreateResourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateResourceRequest $request)
    {
        $this->authorize('create', Resource::class);
        return back()->with(['flash_success' => $request->createResource()]);
    }

    public function show($id)
    {
        //
    }

    /**
     * @param \App\Resource $resource
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Resource $resource)
    {
        $this->authorize('update', $resource);
        return view('resource.edit', compact('resource'));
    }

    /**
     * @param \App\Http\Requests\UpdateResourceRequest $request
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $this->authorize('update', $resource);
        return redirect()->route('resources.index')->with(['flash_success' => $request->updateResource($resource)]);
    }

    /**
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Resource $resource)
    {
        $this->authorize('delete', $resource);
        $resource->delete();
        return back()->with(['flash_success' => "Curso {$resource->name} eliminado con éxito."]);
    }
}
