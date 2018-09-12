<?php

namespace App\Http\Requests\Tenant;

use DB;
use App\{BranchOffice, Resource, Invoice};
use Illuminate\Foundation\Http\FormRequest;

class AccountsReceivableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_id' => 'required|numeric',
            'resources' => 'nullable|array',
            'paid_out' => 'required|numeric',
            'cash_received' => 'required|numeric'
        ];
    }

    public function createAccountReceivable(BranchOffice $branchOffice)
    {
        return DB::transaction(function () use ($branchOffice){
            $invoice = Invoice::findOrFail(request('invoice_id'));

            $payment = $invoice->payments()->create([
                'payment_amount' => $this->paid_out,
                'cash_received' => $this->cash_received
            ]);

            if ($this->resources) {
                collect(request('resources'))->unique('id')->each(function ($resources) use ($invoice) {
                    $resource = Resource::findOrFail($resources['id']);
                    $invoice->resources()->attach($resource->id,  ['price' => $resource->price]);
                });
            }

            if (((int) $invoice->total - $invoice->balance) == 0){
                $invoice->status = Invoice::STATUS_COMPLETE;
                $invoice->save();
            }

            return $payment;
        });
    }
}
