<?php

namespace App\DataTables;

use App\TypeCourse;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantTypeCourseTrashedDataTable extends DataTable
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
            ->addColumn('Fechas', function (TypeCourse $typeCourse) {
                return "<p><b>Creación:</b> {$typeCourse->created_at->format('d/m/Y')}</p>
                        <p><b>Actualización:</b> {$typeCourse->updated_at->format('d/m/Y')}</p>";
            })
            ->addColumn('action', function (TypeCourse $typeCourse) {
                return view('tenant.type_course._actions', compact('typeCourse'));
            })
            ->rawColumns(['action', 'Fechas']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->branchOffice
            ->typecourses()
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
            'name' => ['title' => 'Tipo de recurso'],
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
        return 'TenantTypeCourseTrashed_' . date('YmdHis');
    }
}
