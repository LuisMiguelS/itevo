<?php

namespace App\DataTables;

use App\Promotion;
use Yajra\DataTables\Services\DataTable;

class TenantPromotionDataTable extends DataTable
{
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
                if ($promotion->status === Promotion::STATUS_CURRENT) {
                    return "<span class=\"label label-primary\">".strtoupper($promotion->status)."</span>";
                }
                return "<span class=\"label label-success\">".strtoupper($promotion->status)."</span>";

            })
            ->editColumn('created_at', function(Promotion $promotion) {
                return $promotion->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(Promotion $promotion) {
                return $promotion->updated_at->format('l j F Y');
            })
            ->addColumn('action', function (Promotion $promotion) {
                return view('tenant.promotion._actions', compact('promotion'));
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->branchOffice->promotions()->orderByDesc('promotion_no')->get();
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
                    ->addAction(['width' => '80px', 'title' => 'Acciones', 'printable' => false, 'exportable' => false])
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
            'created_at' => ['title' => 'Fecha de creación'],
            'updated_at' => ['title' => 'Fecha de actualización']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantPromotion_' . date('YmdHis');
    }
}
