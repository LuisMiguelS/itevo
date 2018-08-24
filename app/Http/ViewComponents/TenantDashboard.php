<?php

namespace App\Http\ViewComponents;

use App\{BranchOffice, Period};
use Illuminate\Contracts\Support\Htmlable;

class TenantDashboard implements Htmlable
{
    /**
     * @var \App\BranchOffice
     */
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
        $promotion = $this->branchOffice->currentPromotion();
        $period = optional($promotion)->currentPeriod() ?? new period;

        return view('tenant.dashboard')
            ->with([
                'branchOffice' => $this->branchOffice,
                'promotion' => $promotion,
                'period' => $period
            ])
            ->render();
    }
}