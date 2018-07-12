<?php

namespace App\Http\Requests\Tenant;

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
            'promotion_no' => 'required|numeric'
        ];
    }

    public function updatePromotion($promotion)
    {
        $promotion->update($this->validated());
        return "Promocion no. {$promotion->promotion_no} actualizada correctamente.";
    }
}
