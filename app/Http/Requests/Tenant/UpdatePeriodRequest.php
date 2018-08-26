<?php

namespace App\Http\Requests\Tenant;

use App\Period;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePeriodRequest extends FormRequest
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
            'period_no' => [
                'required',
                'in:' .Period::PERIOD_NO_1. ',' .Period::PERIOD_NO_2. ',' .Period::PERIOD_NO_3,
                Rule::unique('periods')->ignore($this->period->id)->where(function ($query) {
                    return $query->where([
                        ['promotion_id', $this->promotion->id],
                        ['period_no', $this->request->get('period_no')],
                    ]);
                }),
            ],
            'start_at' => 'required|date',
            'ends_at' => 'required|date',
            'status' => [
                'required',
                'in:' .Period::STATUS_WITHOUT_STARTING. ',' .Period::STATUS_CURRENT. ',' .Period::STATUS_FINISHED,
            ]
        ];
    }

    public function attributes()
    {
        return [
            'period_no' => 'periodo',
            'start_at' => 'inicio del periodo',
            'ends_at' => 'fin del periodo',
            'status' => 'estado'
        ];
    }

    public function updatePeriod(Period $period)
    {
        $period->update($this->getFields());
        return "Periodo {$period->period} actualizado correctamente.";
    }

    protected function getFields()
    {
       $this->extraValidation();

        return [
            'period_no' => $this->period_no,
            'start_at' => $this->period->status === Period::STATUS_CURRENT ? $this->period->start_at : new Carbon($this->start_at),
            'ends_at' => $this->period->status === Period::STATUS_CURRENT ? $this->period->ends_at : new Carbon($this->ends_at),
            'status' => $this->period->status === Period::STATUS_CURRENT && $this->validated()['status'] === Period::STATUS_WITHOUT_STARTING ? $this->period->status : $this->status,
        ];
    }

    protected function extraValidation()
    {
        $this->isLastPeriodEndsAtGreater();

        $this->isStartDateAtGraterThanOrEqualToEndsAt();
    }

    protected function isLastPeriodEndsAtGreater()
    {
        if ($previous_period = $this->getPreviosPeriod()) {
            $previous_ends_at = new Carbon($previous_period->ends_at);
            $new_start_at = new Carbon($this->start_at);

            abort_if($previous_ends_at->greaterThan($new_start_at),
                Response::HTTP_BAD_REQUEST,
                "Tu fecha de inicio elegida [{$new_start_at->toDateTimeString()}] debe ser mayor que [{$previous_ends_at->toDateTimeString()}] la fecha de finalizacion del periodo anterior");
        }
    }

    protected function getPreviosPeriod()
    {
        return $this->promotion->periods()
            ->where('id', '<>', $this->period->id)
            ->orderByDesc('id')->first();
    }

    protected function isStartDateAtGraterThanOrEqualToEndsAt()
    {
        $start_at = new Carbon($this->start_at);
        $ends_at = new Carbon($this->ends_at);

        abort_if($start_at->greaterThanOrEqualTo($ends_at),
            Response::HTTP_BAD_REQUEST,
            "La fecha de inicio no puede ser mayor que la de finalizacion");
    }
}
