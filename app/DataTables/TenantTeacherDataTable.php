<?php

namespace App\DataTables;

use App\Teacher;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantTeacherDataTable extends DataTable
{
    use DatatableRemoveButton;

    protected $btn_ability = [
        'tenant-create' => \App\Teacher::class
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
            ->editColumn('name', function (Teacher $teacher) {
                return "<strong>{$teacher->full_name}</strong> 
                <br> 
                <small>Telefono: {$teacher->phone}</small>
                <br>
                <small>Cedula: {$teacher->id_card}</small>";
            })
            ->addColumn('Fechas', function (Teacher $teacher) {
                return "<p><b>Creación:</b> {$teacher->created_at->format('d/m/Y')}</p>
                        <p><b>Actualización:</b> {$teacher->updated_at->format('d/m/Y')}</p>";
            })
            ->addColumn('action', function (Teacher $teacher) {
                return view('tenant.teacher._actions', compact('teacher'));
            })
            ->rawColumns(['action', 'Fechas', 'name']);
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
            'id' => ['visible' => false, 'exportable' => false, 'printable' => false],
            'name' => ['title' => 'Profesor'],
            'last_name' => ['visible' => false, 'exportable' => false, 'printable' => false],
            'id_card' => ['title' => 'Cedula', 'visible' => false, 'exportable' => false, 'printable' => false],
            'phone' => ['title' => 'Teléfono', 'visible' => false, 'exportable' => false, 'printable' => false],
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
        return 'TenantTeacher_' . date('YmdHis');
    }
}
