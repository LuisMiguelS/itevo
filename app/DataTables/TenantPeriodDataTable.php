<?php

namespace App\DataTables;

use App\Period;
use Yajra\DataTables\Services\DataTable;

class TenantPeriodDataTable extends DataTable
{
    private $label_status = [
        Period::STATUS_WITHOUT_STARTING => 'warning',
        Period::STATUS_CURRENT => 'primary',
        Period::STATUS_FINISHED => 'success',
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
            ->editColumn('status', function(Period $period) {
                return $this->status($period);

            })
            ->editColumn('start_at', function(Period $period) {
                if ($period->getOriginal('start_at') === null)
                    return '<span class="label label-danger">Sin definir</span>';
                return $period->start_at->format('d/m/Y');
            })
            ->editColumn('ends_at', function(Period $period) {
                if ($period->getOriginal('ends_at') === null)
                    return '<span class="label label-danger">Sin definir</span>';
                return $period->ends_at->format('d/m/Y');
            })
            ->editColumn('created_at', function(Period $period) {
                return $period->created_at->format('d/m/Y');
            })
            ->editColumn('updated_at', function(Period $period) {
                return $period->updated_at->format('d/m/Y');
            })
            ->addColumn('dates', function (Period $period) {
                return "<small><strong>Creación:</strong> {$period->created_at->format('d/m/Y')}</small><br>
                        <small><strong>Actualización:</strong> {$period->updated_at->format('d/m/Y')}</small>";
            })
            ->addColumn('action', function (Period $period) {
                return view('tenant.period._actions', compact('period'));
            })
            ->rawColumns(['action', 'status', 'dates', 'start_at', 'ends_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->promotion->periods()->get();
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
            'id' => ['title' => 'Identificador', 'visible' => false, 'exportable' => false, 'printable' => false],
            'period_no' =>  ['title' => 'Período'],
            'status' => ['title' => 'Estado'],
            'start_at' => ['title' => 'Inicio del período'],
            'ends_at' => ['title' => 'Fin del período'],
            'created_at' => ['title' => 'Fecha de creación', 'visible' => false],
            'updated_at' => ['title' => 'Fecha de actualización', 'visible' => false],
            'dates' => ['title' => 'Fechas', 'exportable' => false, 'printable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantPeriod_' . date('YmdHis');
    }

    public function status(Period $period)
    {
        return "<span class=\"label label-{$this->label_status[$period->status]}\">".strtoupper($period->status)."</span>";
    }
}
