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
        $promotions = $branchOffice->promotions()->paginate();
        return view('tenant.promotion.index', compact('branchOffice', 'promotions'));
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
        return redirect()->route('tenant.courses.index', $branchOffice)->with(['flash_success' => $request->createPromotion($branchOffice)]);
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
        return redirect()->route('tenant.courses.index', $branchOffice)->with(['flash_success' => $request->updatePromotion($promotion)]);
    }

}
