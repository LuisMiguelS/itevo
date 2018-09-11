<?php

namespace App\DataTables;

use App\Course;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantCourseDataTable extends DataTable
{
    use DatatableRemoveButton;

    protected $btn_ability = [
        'tenant-create' => \App\Course::class
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
            ->addColumn('Fechas', function (Course $course) {
                return "<p><b>Creación:</b> {$course->created_at->format('d/m/Y')}</p>
                        <p><b>Actualización:</b> {$course->updated_at->format('d/m/Y')}</p>";
            })
            ->addColumn('action', function (Course $course) {
                return view('tenant.course._actions', compact('course'));
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
        return 'TenantCourse_' . date('YmdHis');
    }
}
