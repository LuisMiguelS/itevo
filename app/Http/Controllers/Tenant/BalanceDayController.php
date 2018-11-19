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
        if ($this->getBalanceDayResource()->count() > 0 && $this->getBalanceDayResource()[0] != null) {
            return $this->getBalanceDayResource();
        }

        return [];
    }

    protected function getBalanceDayResource()
    {
        return \App\Invoice::with(['payments', 'student' => function ($query) {
            $query->where('branch_office_id', request()->branchOffice->id);
        }])->get()->pluck('resources')->map(function ($resource) {
            if (now()->toDateString() === $resource->toArray()[0]['created_at']->toDateString()
                && request('cuadre') == strtolower($resource->toArray()[0]['name'])
            ) {
                return [
                    'factura' => $resource->toArray()[0]['pivot']['invoice_id'],
                    'cuadre' => $resource->toArray()[0]['name'],
                    'precio' => $resource->toArray()[0]['price'],
                    'fecha' => $resource->toArray()[0]['created_at']->format('d/m/Y'),
                ];
            }
        });
    }

    public function das()
    {
        $incomeDay =  \App\Invoice::with(['payments', 'student' => function ($query) use($branchOffice){
            $query->where('branch_office_id', $branchOffice->id);
        }])->get()->pluck('resources')->collapse()->sum(function ($resources) {
            if (now()->toDateString() === $resources->created_at->toDateString()) {
                return $resources->price;
            }
        });

        /* $incomeDay =  \App\Invoice::with(['payments', 'student' => function ($query) use($branchOffice){
             $query->where('branch_office_id', $branchOffice->id);
         }])->get()->pluck('payments')->collapse()->sum(function ($payment) {
             if (now()->toDateString() === $payment->created_at->toDateString()) {
                 return $payment->payment_amount;
             }
         });*/

        dd($incomeDay);
    }
}
