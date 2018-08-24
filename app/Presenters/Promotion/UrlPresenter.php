<?php

namespace App\Presenters\Promotion;

use App\{BranchOffice, Promotion};

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

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     */
    public function __construct(BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->branchOffice = $branchOffice;
        $this->promotion = $promotion;
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
        return route('tenant.promotions.edit', [
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.promotions.update',[
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    /**
     * @return string
     */
    public function show()
    {
        return route('tenant.promotions.show',[
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    /**
     * @return string
     */
    public function status()
    {
        return route('tenant.promotions.status',[
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    /**
     * @return string
     */
    public function finish()
    {
        return route('tenant.promotions.finish', [
            'branchOffice' => $this->promotion->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.promotions.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'promotion' => $this->promotion
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.promotions.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->promotion->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.promotions.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->promotion->id
        ]);
    }

}
