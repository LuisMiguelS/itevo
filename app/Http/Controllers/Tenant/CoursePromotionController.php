<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{BranchOffice, CoursePromotion, Promotion};
use App\Http\Requests\Tenant\{StoreCoursePromotionRequest};

class CoursePromotionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
     * @param \App\Http\Requests\Tenant\StoreCoursePromotionRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCoursePromotionRequest $request, BranchOffice $branchOffice, Promotion $promotion)
    {
        $this->authorize('tenant-create', CoursePromotion::class);
        return redirect()
            ->route('tenant.promotions.courses.index', [
                'branchOffice' => $branchOffice,
                'promotion' => $promotion
            ])
            ->with(['flash_success' => $request->createCoursePromotion($promotion)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoursePromotion  $coursePromotion
     * @return \Illuminate\Http\Response
     */
    public function show(CoursePromotion $coursePromotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoursePromotion  $coursePromotion
     * @return \Illuminate\Http\Response
     */
    public function edit(CoursePromotion $coursePromotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoursePromotion  $coursePromotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoursePromotion $coursePromotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoursePromotion  $coursePromotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoursePromotion $coursePromotion)
    {
        //
    }
}
