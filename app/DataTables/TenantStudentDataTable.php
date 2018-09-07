<?php

namespace App\DataTables;

use App\Student;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantStudentDataTable extends DataTable
{
    use DatatableRemoveButton;

    protected $btn_ability = [
        'tenant-create' => \App\Student::class
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
            ->addColumn('Estudiante', function (Student $student) {
                return $student->full_name;
            })
            ->addColumn('Fechas', function (Student $student) {
                return "<small><b>Creación:</b> {$student->created_at->format('l j F Y')}</small> <br>
                        <small><b>Actualización:</b> {$student->updated_at->format('l j F Y')}</small> <br>
                        <small><b>Nacimiento:</b> {$student->birthdate->format('l j F Y')}</small>";
            })
            ->addColumn('action', function (Student $student) {
                return view('tenant.student._actions', compact('student'));
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
            'name' => ['visible' => false, 'exportable' => false, 'printable' => false,],
            'last_name' => ['visible' => false, 'exportable' => false, 'printable' => false,],
            'Estudiante',
            'id_card' => ['title' => 'Cédula'],
            'phone' => ['title' => 'Teléfono'],
            'tutor_id_card' => ['title' => 'Cédula del tutor'],
            'signed_up' => ['title' => 'Inscrito'],
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
        return 'TenantStudent_' . date('YmdHis');
    }
}
