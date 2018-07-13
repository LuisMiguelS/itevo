<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
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
                Rule::unique('promotions')->ignore($this->promotion->id)->where(function ($query) {
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

    public function updatePromotion($promotion)
    {
        $promotion->update($this->validated());
        return "Promocion no. {$promotion->promotion_no} actualizada correctamente.";
    }
}
