<?php

namespace App\DataTables;

use App\TypeCourse;
use Yajra\DataTables\Services\DataTable;

class TenantTypeCourseDataTable extends DataTable
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
            ->editColumn('created_at', function(TypeCourse $typeCourse) {
                return $typeCourse->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(TypeCourse $typeCourse) {
                return $typeCourse->updated_at->format('l j F Y');
            })
            ->addColumn('action', 'tenanttypecourse.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->branchOffice->typecourses;
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
            'name' => ['title' => 'Tipo de Recurso'],
            'created_at' => ['title' => 'Fecha de Creacion'],
            'updated_at' => ['title' => 'Fecha de Actualizacion']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantTypeCourse_' . date('YmdHis');
    }
}
