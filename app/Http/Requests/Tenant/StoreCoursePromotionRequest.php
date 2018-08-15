<?php

namespace App\Http\Requests\Tenant;

use App\Promotion;
use Illuminate\Foundation\Http\FormRequest;

class StoreCoursePromotionRequest extends FormRequest
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
            'course_id' => 'required|numeric',
            'classroom_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
            'price' => 'required|numeric',
            'start_time' => 'required|date',
            'output_time' => 'required|date',
            'start_date_at' => 'required|date',
            'ends_at' => 'required|date',
        ];
    }

    /**
     * @param \App\Promotion $promotion
     * @return string
     */
    public function createCoursePromotion(Promotion $promotion)
    {
        $promotion->coursePromotions()->create($this->validated());
        return "Curso activado correctamente.";
    }
}
