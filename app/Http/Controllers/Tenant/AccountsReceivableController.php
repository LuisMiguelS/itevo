<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\{BranchOffice, Invoice, Student};
use App\Http\Requests\Tenant\AccountsReceivableRequest;

class AccountsReceivableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-update', Invoice::class);

        return view('tenant.accounts_receivable.index', compact('branchOffice'));
    }

    public function store(AccountsReceivableRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-update', Invoice::class);

        return response()->json(['data' => $request->createAccountReceivable($branchOffice)], 201);
    }

    public function students(BranchOffice $branchOffice)
    {
        return response()->json(['data' =>
            Student::query()
                ->where('branch_office_id', $branchOffice->id)
                ->whereHas('invoices', function ($query) {
                    $query->where('status', Invoice::STATUS_PENDING);
                })
                ->with(['invoices' => function ($invoices) {
                    $invoices->where('status', Invoice::STATUS_PENDING)->with(['coursePeriod' => function ($coursePeriod) {
                        $coursePeriod->with('course', 'resources');
                    }]);
                }])
                ->get()
        ], 200);
    }
}
