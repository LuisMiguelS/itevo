<?php

namespace App\DataTables;

use App\CoursePeriod;
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
            ->editColumn('price', function (CoursePeriod $coursePeriod){
                return number_format($coursePeriod->price,2,'.',',');
            })
            ->editColumn('classroom.name', function (CoursePeriod $coursePeriod) {
                return "{$coursePeriod->classroom->name} ({$coursePeriod->classroom->building})";
            })
            ->editColumn('resources', function (CoursePeriod $coursePeriod) {
                return $coursePeriod->resources()->get()->implode('name', ', ');
            })
            ->addColumn('Fechas', function (CoursePeriod $coursePeriod) {
                return "<small><b>Inicio del curso:</b> {$coursePeriod->start_at->format('l j F Y')}</small><br>
                        <small><b>Fin del curso:</b> {$coursePeriod->ends_at->format('l j F Y')}</small><br>
                        <small><b>Creación:</b> {$coursePeriod->created_at->format('l j F Y')}</small><br>
                        <small><b>Actualización:</b> {$coursePeriod->updated_at->format('l j F Y')}</small>";
            })
            ->addColumn('action', function (CoursePeriod $coursePeriod) {
                return view('tenant.course_period._actions', compact('coursePeriod'));
            })
            ->rawColumns(['action', 'Fechas']);
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
        return request()->branchOffice
            ->currentPromotion()
            ->currentPeriod()
            ->coursePeriods()
            ->with('teacher', 'course', 'classroom', 'resources')
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
            'course.name' => ['title' => 'Curso'],
            'classroom.name' => ['title' => 'Aula'],
            'resources' => ['title' => 'Recursos'],
            'teacher.full_name' => ['title' => 'Profesor asignado'],
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
        return 'TenantCoursePeriod_' . date('YmdHis');
    }
}
