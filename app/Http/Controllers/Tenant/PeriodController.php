<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{BranchOffice, Promotion, Period};
use App\Http\Requests\Tenant\StorePeriodRequest;
use Symfony\Component\HttpFoundation\Response;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StorePeriodRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePeriodRequest $request, BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-create', Period::class);
        $this->storeHelpers($promotion);
        return redirect()->route('tenant.promotions.periods.index', [
            'branchOffice' => $branchOffice,
            'promotion' => $promotion
        ])->with(['flash_success' => $request->createPeriod($promotion)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(Period $period)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchOffice $branchOffice, Period $period)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        //
    }

    /**
     * @param \App\Promotion $promotion
     */
    protected function storeHelpers(Promotion $promotion): void
    {
        abort_if($promotion->periods()->count() >= 3, Response::HTTP_BAD_REQUEST, 'No puedes crear mas de 3 periodos por promocion');

        abort_if($promotion->periods()->where('status', Period::STATUS_WITHOUT_STARTING)->first(), Response::HTTP_BAD_REQUEST, 'Hay un periodo sin comenzar, No puedes tener 2 periodos sin comenzar al mismo tiempo');
    }
}
