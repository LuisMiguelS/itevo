<?php

namespace App\Presenters\Resource;

use App\{BranchOffice, Resource};

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Resource
     */
    private $resource;

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Resource $resource
     */
    public function __construct(BranchOffice $branchOffice, Resource $resource)
    {
        $this->branchOffice = $branchOffice;
        $this->resource = $resource;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->$key();
        }

        return $this->$key;
    }

    /**
     * @return string
     */
    public function edit()
    {
        return route('tenant.resources.edit', [
            'branchOffice' => $this->branchOffice,
            'resource' => $this->resource
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.resources.update',[
            'branchOffice' => $this->branchOffice,
            'resource' => $this->resource
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.resources.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'resource' => $this->resource
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.resources.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->resource->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.resources.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->resource->id
        ]);
    }
}
