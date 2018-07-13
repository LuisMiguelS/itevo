<?php

namespace App\Presenters\Promotion;

use App\BranchOffice;
use App\Promotion;

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Promotion
     */
    private $promotion;

    public function __construct(BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->branchOffice = $branchOffice;
        $this->promotion = $promotion;
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
        return route('tenant.promotions.destroy', [
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    public function edit()
    {
        return route('tenant.promotions.edit', [
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    public function update()
    {
        return route('tenant.promotions.update',[
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    public function show()
    {
        return route('tenant.promotions.show',[
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    public function status()
    {
        return route('tenant.promotions.status',[
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }


}
