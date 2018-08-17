<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class TenantCoursePeriodDataTable extends DataTable
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
            ->addColumn('action', 'tenantcourseperiod.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @return array
     */
    public function query()
    {
        if (request()->branchOffice->currentPromotion() == null
            || request()->branchOffice->currentPromotion()->currentPeriod() == null) {
            return [];
        }
        return request()->branchOffice->currentPromotion()->currentPeriod()->coursePeriods;
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
                    ->addAction(['width' => '80px'])
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
            'id',
            'price',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantCoursePeriod_' . date('YmdHis');
    }
}
