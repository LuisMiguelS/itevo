<?php

namespace App\Http\Requests\Tenant;

use App\Rules\PositiveNumber;
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
                new PositiveNumber
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
        $lastPromotion = $branchOffice
            ->promotions()
            ->latest()
            ->first();

        if ($lastPromotion) {
            $promotion = $branchOffice->promotions()->create([
                'promotion_no' => $this->promotion_no,
                'created_at' => now()->addYear(($lastPromotion->created_at->year - now()->year) + 1)
            ]);
        }else{
            $promotion = $branchOffice->promotions()->create([
                'promotion_no' => $this->promotion_no
            ]);
        }

        return "Promocion No. {$promotion->promotion_no} creada correctamente.";
    }
}
