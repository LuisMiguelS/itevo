<?php

namespace App\Presenters\BranchOffice;

use App\BranchOffice;

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    public function __construct(BranchOffice $branchOffice)
    {

        $this->branchOffice = $branchOffice;
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
        return route('branchOffices.destroy', [
            'branchOffice' => $this->branchOffice
        ]);
    }

    public function edit()
    {
        return route('branchOffices.edit', [
            'branchOffice' => $this->branchOffice
        ]);
    }

    public function update()
    {
        return route('branchOffices.update',[
            'branchOffice' => $this->branchOffice
        ]);
    }
}
