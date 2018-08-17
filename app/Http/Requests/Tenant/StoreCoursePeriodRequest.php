<?php

namespace App\Http\Requests\Tenant;

use App\Period;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCoursePeriodRequest extends FormRequest
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
            'start_at' => 'required|date',
            'ends_at' => 'required|date',
        ];
    }

    /**
     * @param \App\Period $period
     * @return string
     */
    public function createCoursePromotion(Period $period)
    {
        $this->additionalValidation();
        $period->coursePeriods()->create($this->validated());
        return "Curso activado correctamente.";
    }

    protected function additionalValidation()
    {
        abort_unless($this->period->status === Period::STATUS_CURRENT, 400, "No hay un periodo actual, para esta promocion");

        $period_start_at = new Carbon($this->period->start_at);
        $current_model_start_at = new Carbon($this->validated()['start_at']);

        abort_if($current_model_start_at->lessThan($period_start_at), 400, "La fecha de inicio del curso actual, no puede ser menor que la del periodo actual");

        $period_ends_at = new Carbon($this->period->ends_at);
        $current_model_ends_at = new Carbon($this->validated()['ends_at']);
        abort_if($current_model_ends_at->greaterThan($period_ends_at), 400, "La fecha de finalizacion del curso actual, no puede ser mayor que la del periodo actual");

    }
}
