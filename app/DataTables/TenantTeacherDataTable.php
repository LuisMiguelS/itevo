<?php

namespace App\DataTables;

use App\Teacher;
use Yajra\DataTables\Services\DataTable;

class TenantTeacherDataTable extends DataTable
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
            ->editColumn('created_at', function(Teacher $teacher) {
                return $teacher->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(Teacher $teacher) {
                return $teacher->updated_at->format('l j F Y');
            })
            ->addColumn('action', function (Teacher $teacher) {
                return view('tenant.teacher._actions', compact('teacher'));
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->branchOffice->teachers;
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
            'name' => ['title' => 'Nombre(s)'],
            'last_name' => ['title' => 'Apellido(s)'],
            'id_card' => ['title' => 'Cedula'],
            'phone' => ['title' => 'Teléfono'],
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
        return 'TenantTeacher_' . date('YmdHis');
    }
}
