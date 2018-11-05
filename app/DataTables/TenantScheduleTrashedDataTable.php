<?php

namespace App\DataTables;

use App\Schedule;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantScheduleTrashedDataTable extends DataTable
{
    use DatatableRemoveButton;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('Horarios', function (Schedule $schedule) {
                return "<p>{$schedule->weekday} {$schedule->start_at->format('h:i:s A')} - {$schedule->ends_at->format('h:i:s A')} </p>";
            })
            ->addColumn('Fechas', function (Schedule $schedule) {
                return "<p><b>Creación:</b> {$schedule->created_at->format('d/m/Y')}</p>
                        <p><b>Actualización:</b> {$schedule->updated_at->format('d/m/Y')}</p>";
            })
            ->addColumn('action', function (Schedule $schedule) {
                return view('tenant.schedule._actions', compact('schedule'));
            })
            ->rawColumns(['Horarios', 'Fechas', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Schedule $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Schedule $model)
    {
        return $model->newQuery()
            ->where('branch_office_id', request()->branchOffice->id)
            ->onlyTrashed();
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
            'id' => ['title' => 'Identificador', 'visible' => false, 'exportable' => false, 'printable' => false,],
            'start_at' => ['visible' => false, 'exportable' => false, 'printable' => false,],
            'ends_at' => ['visible' => false, 'exportable' => false, 'printable' => false,],
            'Horarios',
            'Fechas',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantScheduleTrashed_' . date('YmdHis');
    }
}
