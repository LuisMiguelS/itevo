<?php

namespace App\DataTables;

use App\Resource;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantResourceTrashedDataTable extends DataTable
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
            ->addColumn('Fechas', function (Resource $resource) {
                return "<p><b>Fecha de creación:</b> {$resource->created_at->format('l j F Y')}</p>
                        <p><b>Fecha de actualización:</b> {$resource->updated_at->format('l j F Y')}</p>";
            })
            ->addColumn('action', function (Resource $resource) {
                return view('tenant.resource._actions', compact('resource'));
            })
            ->rawColumns(['Fechas', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->branchOffice
            ->resources()
            ->onlyTrashed()
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
            'name' => ['title' => 'Nombre del recurso'],
            'price' => ['title' => 'Precio'],
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
        return 'TenantResourceTrashed_' . date('YmdHis');
    }
}
