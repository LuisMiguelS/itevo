<?php

namespace App\Http\Controllers\Tenant;

use App\Institute;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    public function index(Institute $institute)
    {
        $promotions = $institute->promotions()->paginate();
        return view('tenant.promotion.index', compact('promotions'));
    }
}
