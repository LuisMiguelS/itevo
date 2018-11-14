<?php

namespace App\DataTables;

use App\CoursePeriod;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantCourseRecordDataTable extends DataTable
{
    use DatatableRemoveButton;

    protected $createRemove = true;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('price', function (CoursePeriod $coursePeriod){
                return number_format($coursePeriod->price,2,'.',',');
            })
            ->editColumn('course', function (CoursePeriod $coursePeriod) {
                return "{$coursePeriod->course->name} ({$coursePeriod->course->typeCourse->name}) <br>
                        <small><b>Profesor:</b> {$coursePeriod->teacher->full_name}</small> <br>
                        <small><b>Estudiantes Inscritos:</b> {$coursePeriod->students_count}</small> <br>";
            })
            ->editColumn('classroom.name', function (CoursePeriod $coursePeriod) {
                return "{$coursePeriod->classroom->name} ({$coursePeriod->classroom->building})";
            })
            ->addColumn('Fechas', function (CoursePeriod $coursePeriod) {
                return "<small><b>Inicio del curso:</b> {$coursePeriod->start_at->format('d/m/Y')}</small><br>
                        <small><b>Fin del curso:</b> {$coursePeriod->ends_at->format('d/m/Y')}</small><br>
                        <small><b>Creación:</b> {$coursePeriod->created_at->format('d/m/Y')}</small><br>
                        <small><b>Actualización:</b> {$coursePeriod->updated_at->format('d/m/Y')}</small>";
            })
            ->addColumn('action', function (CoursePeriod $coursePeriod) {
                return view('tenant.course_period._actions', compact('coursePeriod'));
            })
            ->rawColumns(['action', 'Fechas', 'course']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\CoursePeriod $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CoursePeriod $model)
    {
        return $model->newQuery()
            ->with('teacher', 'course', 'classroom')
            ->withCount('students')
            ->whereHas('course', function ($query) {
                $query->where('id', request()->branchOffice->id);
            })
            ->orderByDesc('id');
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
            'id' => ['title' => 'Identificador', 'visible' => false, 'exportable' => false, 'printable' => false],
            'course' => ['title' => 'Curso'],
            'classroom.name' => ['title' => 'Aula'],
            'teacher.full_name' => ['title' => 'Profesor asignado', 'visible' => false, 'exportable' => false, 'printable' => false],
            'price'=> ['title' => 'Precio'],
            'Fechas' => ['width' => '200px'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TenantCourseRecord_' . date('YmdHis');
    }
}
