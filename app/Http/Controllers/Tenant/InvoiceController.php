<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Invoice};
use App\Http\Controllers\Controller;
use App\DataTables\TenantInvoiceDataTable;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\TenantInvoiceDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantInvoiceDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Invoice::class);

        $title = "Todas los recibo de {$branchOffice->name}";

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'title'));
    }

    public function show(BranchOffice $branchOffice, Invoice $invoice)
    {
        return PDF::loadView('tenant.invoice.template', compact('branchOffice', 'invoice'))
            ->setPaper('A4')
            ->stream("FACTURA#{$invoice->id}");
    }
}
