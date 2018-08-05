<?php

namespace App\DataTables;

use App\Student;
use Yajra\DataTables\Services\DataTable;

class TenantStudentDataTable extends DataTable
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
            ->editColumn('created_at', function(Student $student) {
                return $student->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(Student $student) {
                return $student->updated_at->format('l j F Y');
            })
            ->addColumn('action', function (Student $student) {
                return view('tenant.student._actions', compact('student'));
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
        return request()->branchOffice->students;
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
            'id_card' => ['title' => 'Cédula'],
            'phone' => ['title' => 'Teléfono'],
            'address' => ['title' => 'Dirección'],
            'tutor_id_card' => ['title' => 'Cédula del tutor'],
            'signed_up' => ['title' => 'Inscrito'],
            'birthdate' => ['title' => 'Fecha de nacimiento'],
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
        return 'TenantStudent_' . date('YmdHis');
    }
}
