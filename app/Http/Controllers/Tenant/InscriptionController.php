<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\InscriptionRequest;
use App\{BranchOffice};

class InscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(BranchOffice $branchOffice)
    {
        return view('tenant.inscription.index')
            ->with(['branchOffice' => $branchOffice]);
    }

    public function store(InscriptionRequest $request, BranchOffice $branchOffice)
    {
        return response()->json(['data' => $request->createInscription($branchOffice)], 201);
    }

    public function students(BranchOffice $branchOffice)
    {
        return response()->json(['data' => $branchOffice->students], 200);
    }

    public function courses(BranchOffice $branchOffice)
    {
        return response()->json(['data' =>
            $branchOffice->currentPromotion()
            ->currentPeriod()
            ->coursePeriods()
            ->with('teacher', 'course', 'classroom', 'schedules', 'resources')
            ->get()
        ], 200);
    }
}
