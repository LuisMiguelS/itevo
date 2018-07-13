<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice,Promotion};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\StorePromotionRequest;
use App\Http\Requests\Tenant\UpdatePromotionRequest;

class PromotionController extends Controller
{
    /**
     * PromotionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Promotion::class);
        $promotions = $branchOffice->promotions()->orderByDesc('promotion_no')->paginate();
        return view('tenant.promotion.index', compact('branchOffice', 'promotions'));
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-view', Promotion::class);
        abort_unless($promotion->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Promotion::class);
        $this->thereIsCurrentPromotion($branchOffice);
        return view('tenant.promotion.create', compact('branchOffice'));
    }

    /**
     * @param \App\Http\Requests\Tenant\StorePromotionRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePromotionRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Promotion::class);
        $this->thereIsCurrentPromotion($branchOffice);
        return redirect()->route('tenant.promotions.index', $branchOffice)->with(['flash_success' => $request->createPromotion($branchOffice)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-update', Promotion::class);
        abort_unless($promotion->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return view('tenant.promotion.edit', compact('branchOffice', 'promotion'));
    }

    /**
     * @param \App\Http\Requests\Tenant\UpdatePromotionRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePromotionRequest $request, BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-update', $promotion);
        abort_unless($promotion->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        return redirect()->route('tenant.promotions.index', $branchOffice)->with(['flash_success' => $request->updatePromotion($promotion)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-update', $promotion);
        abort_unless($promotion->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $promotion->delete();
        return redirect()->route('tenant.promotions.index', $branchOffice)->with(['flash_success' => "Promocion no. {$promotion->promotion_no} eliminada correctamente."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function changeStatus(BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-change-status', $promotion);
        abort_unless($promotion->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);
        $promotion->status = Promotion::STATUS_FINISHED;
        $promotion->save();
        return redirect()->route('tenant.promotions.index', $branchOffice)->with(['flash_success' => "Estado de la promocion no. {$promotion->promotion_no} cambiado"]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     */
    public function thereIsCurrentPromotion(BranchOffice $branchOffice): void
    {
        abort_if($branchOffice->promotions()->where('status', Promotion::STATUS_CURRENT)->count() > 0,
            Response::HTTP_CONFLICT,
            'Debes finalizar la promoción actual antes de crear otra');
    }
}
