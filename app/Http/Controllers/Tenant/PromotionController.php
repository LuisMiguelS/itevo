<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Promotion};
use App\Http\Controllers\Controller;

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
}
