<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\{BranchOffice, Invoice, Student};
use App\Http\Requests\Tenant\AccountsReceivableRequest;
use Illuminate\Support\Collection;

class AccountsReceivableController extends Controller
{
    protected $is_current_week = false;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-update', Invoice::class);

        return view('tenant.accounts_receivable.index', compact('branchOffice'));
    }

    public function store(AccountsReceivableRequest $request, BranchOffice $branchOffice)
    {
        $this->authorize('tenant-update', Invoice::class);

        return response()->json(['data' => $request->createAccountReceivable($branchOffice)], 201);
    }

    public function students(BranchOffice $branchOffice)
    {
        return response()->json(['data' =>
            Student::query()
                ->select('id', 'name', 'last_name')
                ->where('branch_office_id', $branchOffice->id)
                ->whereHas('invoices', function ($query) {
                    $query->where('status', Invoice::STATUS_PENDING);
                })
                ->with(['invoices' => function ($invoices) {
                    $invoices->select('id', 'student_id', 'created_at')
                        ->where('status', Invoice::STATUS_PENDING)
                        ->with([
                            'resources:id,name,resources.price,necessary',
                            'payments:id,invoice_id,description,payment_amount,cash_received',
                            'coursePeriod' => function ($coursePeriod) {
                                $coursePeriod->select('id', 'course_id', 'course_period.price', 'start_at', 'ends_at')
                                    ->with([
                                        'course:id,name,type_course_id',
                                        'resources:id,name,price,necessary'
                                    ]);
                        }]);
                }])
                ->get()
        ], 200);
    }

    public function breakdownPendingPayment(BranchOffice $branchOffice, Invoice $invoice)
    {
        abort_unless($invoice->student->branch_office_id == $branchOffice->id, 403);

        return response()->json([
            'data' => $invoice->coursePeriod->transform(function ($item){
                return [
                    'weeks' => $weeks = $item->start_at->diffInWeeks($item->ends_at),
                    'current_week' => (int) $weeks - now()->diffInWeeks($item->ends_at),
                    'price' => $item->price
                ];
            })->flatMap(function ($item) use ($invoice) {
                return Collection::times($item['weeks'], function ($number) use ($item, $invoice) {
                    return [
                        'week' => $number,
                        'payment_per_week' => $payment_per_week = $item['price'] / $item['weeks'],
                        'balance_per_week' =>  $balance_per_week = $payment_per_week * $number,
                        'is_current_week' =>  $this->isCurrentWeek($number, $item['current_week'], $item['weeks']),
                        'pending' => $pending = $this->studentPending($invoice, $item['price']) > $balance_per_week ? 0 : abs($this->studentPending($invoice, $item['price']) - $balance_per_week),
                        'label' => $this->getLabel($pending)
                    ];
                });
            })
        ]);
    }

    protected function isCurrentWeek(int $number, int $current_week, int $last_week)
    {
        $is_current_week = false;

       if ($number == 1
           && $current_week <= $number){
           $is_current_week = true;
       }

       if ($number > 1
           && $number < $last_week
           && $current_week > $number
           && $current_week < $last_week) {
           $is_current_week = true;
       }

        if ($number == $last_week
            && $current_week >= $last_week) {
            $is_current_week = true;
        }

        if ($this->is_current_week == false) {
            $this->is_current_week = $is_current_week;
        }

       return $is_current_week;
    }

    protected function studentPending(Invoice $invoice, int $coursePrice)
    {
        return $invoice->balance - ($invoice->total - $coursePrice);
    }

    protected function getLabel(int $pending)
    {
        if ($pending == 0) {
            return "success";
        }

        if ($pending > 0
            &&   $this->is_current_week == false) {
            return "danger";
        }

        if ($pending > 0
            &&   $this->is_current_week == true) {
            return "info";
        }
    }
}
