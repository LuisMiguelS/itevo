<?php

namespace App\DataTables;

use App\Teacher;
use App\Traits\DatatableRemoveButton;
use Yajra\DataTables\Services\DataTable;

class TenantTeacherTrashedDataTable extends DataTable
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
            ->addColumn('Fechas', function (Teacher $teacher) {
                return "<p><b>Fecha de creación:</b> {$teacher->created_at->format('l j F Y')}</p>
                        <p><b>Fecha de actualización:</b> {$teacher->updated_at->format('l j F Y')}</p>";
            })
            ->addColumn('action', function (Teacher $teacher) {
                return view('tenant.teacher._actions', compact('teacher'));
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
            ->teachers()
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
            'name' => ['title' => 'Nombre(s)'],
            'last_name' => ['title' => 'Apellido(s)'],
            'id_card' => ['title' => 'Cedula'],
            'phone' => ['title' => 'Teléfono'],
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
        return 'TenantTeacherTrashed_' . date('YmdHis');
    }
}
