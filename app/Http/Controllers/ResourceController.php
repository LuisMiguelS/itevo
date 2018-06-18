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

    public function index()
    {
        $this->authorize('view', Resource::class);
        
        $resources = Resource::all();

        return view('resource.index', compact('resources'));
    }

    public function create()
    {
        $this->authorize('create', Resource::class);

        return view('resource.create');
    }

    public function store(CreateResourceRequest $request)
    {
        $this->authorize('create', Resource::class);

        return back()->with(['flash_success' => $request->createResource()]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Resource $resource)
    {
        $this->authorize('update', $resource);

        return view('resource.edit', compact('resource'));
    }

    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        return redirect()->route('resources.index')->with(['flash_success' => $request->updateResource($resource)]);
    }

    public function destroy(Resource $resource)
    {
        $this->authorize('delete', $resource);

        $resource->delete();

        return back()->with(['flash_success' => "Curso {$resource->name} eliminado con éxito."]);
    }
}
