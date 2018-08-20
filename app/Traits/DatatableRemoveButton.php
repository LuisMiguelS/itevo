<?php

namespace App\Traits;

trait DatatableRemoveButton
{
    protected $parameters;

    public function __construct()
    {
        $this->parameters = config('datatables-buttons.parameters');
        $this->removeCreateButton();
    }

    protected function removeCreateButton()
    {
        if (! auth()->user()->can('tenant-create', $this->btn_ability['tenant-create']) || request()->route()->getActionMethod() === 'trashed')
            unset($this->parameters['buttons'][0]);
    }

    protected function getBuilderParameters()
    {
        return $this->parameters;
    }
}