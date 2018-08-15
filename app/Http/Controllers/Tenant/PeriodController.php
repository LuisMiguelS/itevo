<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\DataTables\TenantPeriodDataTable;
use App\{BranchOffice, Promotion, Period};
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StorePeriodRequest, UpdatePeriodRequest};

class PeriodController extends Controller
{
    /**
     * PeriodController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\TenantPeriodDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantPeriodDataTable $dataTable, BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-view', Period::class);
        $title = "Todos los periodos de la promocion: {$promotion->promotion_no}";
        return $dataTable->render('datatables.tenant', compact('branchOffice', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-create', Period::class);
        $period = new Period;
        return view('tenant.period.create', compact('branchOffice', 'promotion', 'period'));
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
        abort_unless($promotion->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $this->storeHelpers($promotion);
        return redirect()->route('tenant.promotions.periods.index', [
            'branchOffice' => $branchOffice,
            'promotion' => $promotion
        ])->with(['flash_success' => $request->createPeriod($promotion)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @param  \App\Period $period
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Promotion $promotion, Period $period)
    {
        $this->authorize('tenant-update', $period);
        $this->updateHelpers($period);
        return view('tenant.period.edit', compact('branchOffice', 'promotion', 'period'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdatePeriodRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @param  \App\Period $period
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePeriodRequest $request, BranchOffice $branchOffice, Promotion $promotion, Period $period)
    {
        $this->authorize('tenant-update', $period);
        abort_unless($promotion->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $this->updateHelpers($period);
        return redirect()->route('tenant.promotions.periods.index', [
            'branchOffice' => $branchOffice,
            'promotion' => $promotion
        ])->with(['flash_success' => $request->updatePeriod($period)]);
    }


    /**
     * @param \App\Promotion $promotion
     */
    protected function storeHelpers(Promotion $promotion): void
    {
        abort_if($promotion->periods()->count() >= 3, Response::HTTP_BAD_REQUEST, 'No puedes crear mas de 3 periodos por promocion');

        abort_if($promotion->periods()->where('status', Period::STATUS_WITHOUT_STARTING)->first(), Response::HTTP_BAD_REQUEST, 'Hay un periodo sin comenzar, No puedes tener 2 periodos sin comenzar al mismo tiempo');
    }

    /**
     * @param \App\Period $period
     */
    protected function updateHelpers(Period $period): void
    {
        abort_if($period->status == Period::STATUS_FINISHED, Response::HTTP_BAD_REQUEST, 'No puedes editar un periodo finalizado');
    }
}
