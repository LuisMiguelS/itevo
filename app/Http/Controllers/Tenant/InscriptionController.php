<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice};
use App\Http\Controllers\Controller;

class InscriptionController extends Controller
{
    public function index(BranchOffice $branchOffice)
    {
        return view('tenant.inscription.index')
            ->with(['branchOffice' => $branchOffice]);
    }
}
