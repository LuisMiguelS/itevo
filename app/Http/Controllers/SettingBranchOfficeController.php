<?php

namespace App\Http\Controllers;

use App\BranchOffice;

class SettingBranchOfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-settings', $branchOffice);

        return view('tenant.branch_office.settings', ['branchOffice' => $branchOffice]);
    }

    public function settings(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-settings', $branchOffice);

       request()->validate([
            'phone' => ['required', 'min:14', 'max:14'],
            'address' => ['required', 'min:15']
        ]);

        $branchOffice->update([
            'settings' => [
                'phone' => request('phone'),
                'address' => request('address'),
            ]
        ]);

        return back()->with(['flash_success' => "Configuraciones de {$branchOffice->name} actualizadas con exito."]);
    }
}
