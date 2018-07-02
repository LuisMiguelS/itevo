<?php

namespace App\Presenters\Resource;

use App\BranchOffice;
use App\Resource;

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

    public function __construct(BranchOffice $branchOffice, Resource $resource)
    {
        $this->branchOffice = $branchOffice;
        $this->resource = $resource;
    }

    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->$key();
        }

        return $this->$key;
    }

    public function delete()
    {
        return route('tenant.resources.destroy', [
            'branchOffice' => $this->branchOffice,
            'resource' => $this->resource
        ]);
    }

    public function edit()
    {
        return route('tenant.resources.edit', [
            'branchOffice' => $this->branchOffice,
            'resource' => $this->resource
        ]);
    }

    public function update()
    {
        return route('tenant.resources.update',[
            'branchOffice' => $this->branchOffice,
            'resource' => $this->resource
        ]);
    }
}
