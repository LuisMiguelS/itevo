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
            ->editColumn('name', function (Resource $resource) {
                if ($resource->necessary) {
                    return "{$resource->name} <span class='text-danger' style='font-size: large'>*</span>";
                }
                return $resource->name;
            })
            ->editColumn('price', function (Resource $resource){
                return number_format($resource->price,2,'.',',');
            })
            ->addColumn('Fechas', function (Resource $resource) {
                return "<p><b>Creación:</b> {$resource->created_at->format('d/m/Y')}</p>
                        <p><b>Actualización:</b> {$resource->updated_at->format('d/m/Y')}</p>";
            })
            ->addColumn('action', function (Resource $resource) {
                return view('tenant.resource._actions', compact('resource'));
            })
            ->rawColumns(['Fechas', 'action', 'name']);
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
            'name' => ['title' => 'Recurso'],
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
