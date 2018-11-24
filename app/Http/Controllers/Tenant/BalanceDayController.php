<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Resource};
use App\Http\Controllers\Controller;

class BalanceDayController extends Controller
{
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-balance-day', $branchOffice);

        $resources = Resource::where('branch_office_id', $branchOffice->id)->select('id', 'name')->get();

        $balanceDay = $this->getBalanceDay();

        return view('tenant.balance_day.index', compact('branchOffice', 'resources', 'balanceDay'));
    }

    protected function getBalanceDay()
    {
        if ($this->getBalanceDayResource()->count() > 0) {
            return $this->getBalanceDayResource();
        }

        if ($this->getBalanceDayCourse()->count() > 0){
            return $this->getBalanceDayCourse();
        }

        if ($this->getBalanceDayGeneral()->count() > 0){
            return $this->getBalanceDayGeneral();
        }

        return [];
    }

    protected function getBalanceDayResource()
    {
        return \App\Invoice::whereHas('payments', function ($queryPayment) {
            $queryPayment->whereDate('created_at', now());
        })->with(['payments', 'student' => function ($queryStudent) {
            $queryStudent->where('branch_office_id', request()->branchOffice->id);
        }])->get()->pluck('resources')->map(function ($resource) {
            if (request('cuadre') == strtolower($resource->toArray()[0]['name'])) {
                return [
                    'factura' => $resource->toArray()[0]['pivot']['invoice_id'],
                    'cuadre' => $resource->toArray()[0]['name'],
                    'precio' => $resource->toArray()[0]['price'],
                    'fecha' => $resource->toArray()[0]['created_at']->format('d/m/Y'),
                ];
            }
        })->filter();
    }

    protected function getBalanceDayCourse()
    {
        if (! (request('cuadre') == 'cursos')) {
            return collect([]);
        }

        return \App\Invoice::whereHas('payments', function ($queryPayment) {
            $queryPayment->whereDate('created_at', now());
        })->with(['payments', 'student' => function ($queryStudent) {
            $queryStudent->where('branch_office_id', request()->branchOffice->id);
        }])->get()->map(function ($object) {
            if (($object->balance - $object->resources->sum('price')) > 0) {
                return [
                    'factura' => $object->id,
                    'cuadre' => 'Cursos',
                    'precio' => $object->balance - $object->resources->sum('price'),
                    'fecha' => $object->created_at->format('d/m/Y'),
                ];
            }
        })->filter();
    }

    public function getBalanceDayGeneral()
    {
        $resource = \App\Invoice::whereHas('payments', function ($queryPayment) {
            $queryPayment->whereDate('created_at', now());
        })->with(['payments', 'student' => function ($queryStudent) {
            $queryStudent->where('branch_office_id', request()->branchOffice->id);
        }])->get()->pluck('resources')->map(function ($resource) {
            return [
                'factura' => $resource->toArray()[0]['pivot']['invoice_id'],
                'cuadre' => $resource->toArray()[0]['name'],
                'precio' => $resource->toArray()[0]['price'],
                'fecha' => $resource->toArray()[0]['created_at']->format('d/m/Y'),
            ];
        })->filter();

        $course = \App\Invoice::whereHas('payments', function ($queryPayment) {
            $queryPayment->whereDate('created_at', now());
        })->with(['payments', 'student' => function ($queryStudent) {
            $queryStudent->where('branch_office_id', request()->branchOffice->id);
        }])->get()->map(function ($object) {
            if (($object->balance - $object->resources->sum('price')) > 0) {
                return [
                    'factura' => $object->id,
                    'cuadre' => 'Cursos',
                    'precio' => $object->balance - $object->resources->sum('price'),
                    'fecha' => $object->created_at->format('d/m/Y'),
                ];
            }
        })->filter();

        return $resource->merge($course)->filter();
    }
}
