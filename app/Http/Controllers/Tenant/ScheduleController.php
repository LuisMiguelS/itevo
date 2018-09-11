<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Schedule};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Tenant\{StoreSchedulesRequest, UpdateSchedulesRequest};
use App\DataTables\{TenantScheduleDataTable, TenantScheduleTrashedDataTable};

class ScheduleController extends Controller
{
    /**
     * ScheduleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\TenantScheduleDataTable $dataTable
     * @param \App\BranchOffice $branchOffice
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(TenantScheduleDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Schedule::class);

        $breadcrumbs = 'schedule';

        $title = 'Todos los horarios <a href="'. route('tenant.schedules.trash', $branchOffice) .'"class="btn btn-default">Papelera</a>';

        if (! auth()->user()->can('tenant-trash', Schedule::class)) {
            $title = 'Todos los horarios';
        }

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    public function trashed(TenantScheduleTrashedDataTable $dataTable, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-trash', Schedule::class);

        $breadcrumbs = 'schedule-trash';

        $title = 'Todos los horarios en la papelera <a href="'. route('tenant.schedules.index', $branchOffice) .'"class="btn btn-default">Horarios</a>';

        return $dataTable->render('datatables.tenant', compact('branchOffice', 'breadcrumbs', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Schedule::class);

        $schedule = new Schedule;

        return view('tenant.schedule.create', compact('branchOffice', 'schedule'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Tenant\StoreSchedulesRequest $request
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreSchedulesRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Schedule::class);

        return redirect()
            ->route('tenant.schedules.store', $branchOffice)
            ->with(['flash_success' => $request->createSchedule($branchOffice)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Schedule $schedule
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Schedule $schedule)
    {
        $this->authorize('tenant-update', $schedule);

        abort_unless($schedule->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        return view('tenant.schedule.edit', compact('branchOffice', 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Tenant\UpdateSchedulesRequest $request
     * @param \App\BranchOffice $branchOffice
     * @param \App\Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateSchedulesRequest $request, BranchOffice $branchOffice, Schedule $schedule)
    {
        $this->authorize('tenant-update', $schedule);

        abort_unless($schedule->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        return redirect()
            ->route('tenant.schedules.index', $branchOffice)
            ->with(['flash_success' => $request->updateSchedule($schedule)]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(BranchOffice $branchOffice, $id)
    {
        $schedule = Schedule::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-restore', $schedule);

        abort_unless($schedule->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $schedule->restore();

        return redirect()
            ->route('tenant.schedules.trash', $branchOffice)
            ->with(['flash_success' => "Horario restaurado con éxito."]);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @param \App\Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function trash(BranchOffice $branchOffice, Schedule $schedule)
    {
        $this->authorize('tenant-trash', $schedule);

        abort_unless($schedule->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        abort_if($schedule->coursePeriod()->exists(),
            Response::HTTP_BAD_REQUEST,
            "No puedes eliminar el horario, hay informacion que depende de esta");

        $schedule->delete();

        return redirect()
            ->route('tenant.schedules.index', $branchOffice)
            ->with(['flash_success' => "Horario enviado a la papelera con éxito."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(BranchOffice $branchOffice, $id)
    {
        $schedule = Schedule::onlyTrashed()->where('id', $id)->firstOrFail();

        $this->authorize('tenant-delete', $schedule);

        abort_unless($schedule->isRegisteredIn($branchOffice), Response::HTTP_NOT_FOUND);

        $schedule->forceDelete();

        return redirect()
            ->route('tenant.schedules.trash', $branchOffice)
            ->with(['flash_success' => "Horario eliminado con éxito."]);
    }
}
