<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, CoursePeriod, Invoice};
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\InscriptionRequest;

class InscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-store', Invoice::class);

        abort_unless($branchOffice->currentPromotion(), 400, 'No hay una promocion actual');

        return view('tenant.inscription.index')
            ->with(['branchOffice' => $branchOffice]);
    }

    public function store(InscriptionRequest $request, BranchOffice $branchOffice)
    {
       $this->authorize('tenant-store', Invoice::class);

        return response()->json(['data' => $request->createInscription($branchOffice)], 201);
    }

    public function students(BranchOffice $branchOffice)
    {
        return response()->json(['data' => $branchOffice->students], 200);
    }

    public function courses(BranchOffice $branchOffice)
    {
        return response()->json(['data' =>
            CoursePeriod::whereHas('course', function ($query) use ($branchOffice) {
                $query->where('branch_office_id', $branchOffice->id);
            })
                ->has('resources')
                ->has('schedules')
                ->withCount('students')
                ->with('teacher', 'course', 'classroom', 'schedules', 'resources')
                ->whereRaw("start_at > DATE_SUB(NOW(), INTERVAL 7 DAY)")
                ->whereColumn('start_at', '<', 'ends_at')
                ->get()
        ], 200);
    }
}
