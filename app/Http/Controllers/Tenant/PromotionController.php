<?php

namespace App\Http\Controllers\Tenant;

use App\{Institute, Promotion};
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
     * @param \App\Institute $institute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Institute $institute)
    {
        $this->authorize('tenant-view', Promotion::class);
        $promotions = $institute->promotions()->paginate();
        return view('tenant.promotion.index', compact('promotions'));
    }
}
