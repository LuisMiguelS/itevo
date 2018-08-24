<?php

namespace App\Http\ViewComponents;

use App\BranchOffice;
use Illuminate\Contracts\Support\Htmlable;

class TenantQuickAccessBtn implements Htmlable
{
    private $branchOffice;

    public function __construct(BranchOffice $branchOffice)
    {
        $this->branchOffice = $branchOffice;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     * @throws \Throwable
     */
    public function toHtml()
    {
        $period = optional($this->branchOffice->currentPromotion())->currentPeriod();

        return view('partials._quick_access')
            ->with([
                'branchOffice' => $this->branchOffice,
                'period' => $period
            ])
            ->render();
    }
}