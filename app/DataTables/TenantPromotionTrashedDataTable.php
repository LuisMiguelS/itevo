<?php

namespace App\DataTables;

use App\Promotion;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantPromotionTrashedDataTable extends DataTable
{
    use DatatableRemoveButton;

    private $label_status = [
        Promotion::STATUS_CURRENT => 'primary',
        Promotion::STATUS_FINISHED => 'success',
    ];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('status', function(Promotion $promotion) {
                return $this->status($promotion);
            })
            ->addColumn('Fechas', function (Promotion $promotion) {
                return "<p><b>Creación:</b> {$promotion->created_at->format('d/m/Y')}</p>
                        <p><b>Actualización:</b> {$promotion->updated_at->format('d/m/Y')}</p>";
            })
            ->addColumn('action', function (Promotion $promotion) {
                return view('tenant.promotion._actions', compact('promotion'));
            })
            ->rawColumns(['status', 'Fechas', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->branchOffice
            ->promotions()
            ->onlyTrashed()
            ->orderByDesc('promotion_no')
            ->get();
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
            'id' => ['title' => 'Identificador', 'visible' => false, 'exportable' => false, 'printable' => false,],
            'promotion_no' => ['title' => 'Promocion no.'],
            'status' => ['title' => 'Estado'],
            'Fechas'
        ];
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantPromotionTrashed_' . date('YmdHis');
    }

    public function status(Promotion $promotion)
    {
        return "<span class=\"label label-{$this->label_status[$promotion->status]}\">".strtoupper($promotion->status)."</span>";
    }
}
