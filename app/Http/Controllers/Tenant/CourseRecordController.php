<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\{BranchOffice, CoursePeriod};
use App\DataTables\TenantCourseRecordDataTable;

class CourseRecordController extends Controller
{
    public function index(TenantCourseRecordDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', CoursePeriod::class);

        $title = "Historial de los cursos impartidos";

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'title'));
    }
}
