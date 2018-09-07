<?php

namespace App\DataTables;

use App\Invoice;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantInvoiceDataTable extends DataTable
{
    use DatatableRemoveButton;

    protected $createRemove = true;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('full_name', function (Invoice $invoice) {
                return $invoice->student->full_name;
            })
            ->addColumn('total', function (Invoice $invoice) {
                return number_format($invoice->total(),2,'.',',');
            })
            ->editColumn('balance', function (Invoice $invoice) {
                return number_format($invoice->balance,2,'.',',');
            })
            ->addColumn('date', function (Invoice $invoice) {
                return "<small><b>Creación:</b> {$invoice->created_at->format('l j F Y')}</small><br>
                        <small><b>Actualización:</b> {$invoice->updated_at->format('l j F Y')}</small>";
            })
            ->addColumn('action', function (Invoice $invoice) {
                return '<a href="'.route('tenant.invoice.show', ['branchOffice' => request()->branchOffice , 'invoice' => $invoice]).'"  target="_blank" class="btn btn-default btn-xs"> 
                        <i class="fa fa-print" aria-hidden="true"></i>
                        </a>';
            })
            ->addColumn('pays', function (Invoice $invoice) {
                return $invoice->payments->map(function ($payment) {
                   return "<a href='' target='_blank'>Abono #{$payment->id}  a recibo {$payment->invoice_id} - {$payment->created_at->format('d/m/Y')} </a>";
                })->implode('<br>');
            })
            ->rawColumns(['date', 'action', 'pays']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        return $model->query()->with('student')->whereHas('student', function ($query) {
            $query->where('branch_office_id', request()->branchOffice->id);
        });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '100px', 'title' => 'Acciones', 'printable' => false, 'exportable' => false])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['title' => 'Factura', 'visible'],
            'student.name' => ['visible' => false, 'exportable' => false, 'printable' => false],
            'student.last_name' => ['visible' => false, 'exportable' => false, 'printable' => false],
            'full_name' => ['title' => 'Estudiante', 'searchable' => false],
            'total' => ['title' => 'Total'],
            'balance' => ['title' => 'Monto pagado'],
            'created_at' => ['visible' => false, 'exportable' => false, 'printable' => false],
            'updated_at' => ['visible' => false, 'exportable' => false, 'printable' => false],
            'date' => ['title' => 'Fechas'],
            'pays' => ['title' => 'Pagos'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantInvoice_' . date('YmdHis');
    }
}
