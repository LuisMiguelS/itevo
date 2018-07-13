<?php

namespace App\Http\Requests\Tenant;

use App\{BranchOffice, Period};
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
            'promotion_no' => [
                'required',
                'numeric',
                Rule::unique('promotions')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['promotion_no', $this->request->get('promotion_no')],
                    ]);
                }),
            ]
        ];
    }

    public function attributes()
    {
        return [
            'promotion_no' => 'numero de promocion',
        ];
    }

    public function createPromotion(BranchOffice $branchOffice)
    {
        $promotion = $branchOffice->promotions()->create($this->validated());
        $promotion->periods()->create([
            'status' => Period::STATUS_CURRENT,
            'period' => Period::PERIOD_NO_1,
        ]);
        return "Promocion No. {$promotion->promotion_no} creada correctamente.";
    }
}
