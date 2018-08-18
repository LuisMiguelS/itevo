<?php

namespace App\Http\Requests\Tenant;

use Carbon\Carbon;
use App\CoursePeriod;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursePeriodRequest extends FormRequest
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
     * @param \App\CoursePeriod $coursePeriod
     * @return string
     */
    public function updateCoursePeriod(CoursePeriod $coursePeriod)
    {
        $this->additionalValidation();
        $data = $this->validated();
        $data['start_at'] =new Carbon($data['start_at']);
        $data['ends_at'] = new Carbon($data['ends_at']);
        $coursePeriod->update($data);
        return "Curso activado actualizado correctamente.";
    }

    protected function additionalValidation()
    {
        $period_start_at = new Carbon($this->period->start_at);
        $current_model_start_at = new Carbon($this->validated()['start_at']);

        abort_if($current_model_start_at->lessThan($period_start_at), 400, "La fecha de inicio del curso actual, no puede ser menor que la del periodo actual");

        $period_ends_at = new Carbon($this->period->ends_at);
        $current_model_ends_at = new Carbon($this->validated()['ends_at']);
        abort_if($current_model_ends_at->greaterThan($period_ends_at), 400, "La fecha de finalizacion del curso actual, no puede ser mayor que la del periodo actual");

    }
}
