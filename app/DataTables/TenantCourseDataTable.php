<?php

namespace App\DataTables;

use App\Course;
use Yajra\DataTables\Services\DataTable;

class TenantCourseDataTable extends DataTable
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
            ->editColumn('created_at', function(Course $course) {
                return $course->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(Course $course) {
                return $course->updated_at->format('l j F Y');
            })
            ->addColumn('action', function (Course $course) {
                return view('tenant.course._actions', compact('course'));
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
        return request()->branchOffice->courses()->with('typeCourse')->get();
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
            'name' => ['title' => 'Curso'],
            'type_course.name' => ['title' => 'Tipo de curso'],
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
        return 'TenantCourse_' . date('YmdHis');
    }
}
