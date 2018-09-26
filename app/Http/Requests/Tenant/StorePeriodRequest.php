<?php

namespace App\Http\Requests\Tenant;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\{BranchOffice, Period, Promotion};
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePeriodRequest extends FormRequest
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
                'in:'.Period::PERIOD_NO_1.','.Period::PERIOD_NO_2.','.Period::PERIOD_NO_3,
                Rule::unique('periods')->where(function ($query) {
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
                'in:'.Period::STATUS_WITHOUT_STARTING.','.Period::STATUS_CURRENT.','.Period::STATUS_FINISHED,
            ]
        ];
    }

    public function attributes()
    {
        return [
            'period_no' => 'perido',
            'start_at' => 'inicio del periodo',
            'ends_at' => 'fin del periodo',
            'status' => 'estado'
        ];
    }

    public function createPeriod(Promotion $promotion)
    {
        $promotion->periods()->create($this->getFields());

        return "Periodo creado correctamente.";
    }

    protected function getFields()
    {
        $this->extraValidation();

        return [
            'period_no' => $this->period_no,
            'start_at' => new Carbon($this->start_at),
            'ends_at' => new Carbon($this->ends_at),
            'status' => $this->status
        ];
    }

    protected function extraValidation()
    {
        abort_if($this->promotion->periods->last()['status'] === Period::STATUS_CURRENT
            && $this->status != Period::STATUS_WITHOUT_STARTING,
            Response::HTTP_BAD_REQUEST,
            "Debe finalizar el período actual para crear un nuevo período actual o final");

        if ($previous_period = $this->getPreviosPeriod()) {
            $this->isLastPeriodEndsAtGreater($previous_period);
        }

        $this->isStartDateAtGraterThanOrEqualToEndsAt();
    }

    /**
     * @return mixed
     */
    protected function getPreviosPeriod()
    {
        return $this->promotion->periods()->orderByDesc('id')->first();
    }

    /**
     * @param \App\Period $period
     */
    protected function isLastPeriodEndsAtGreater(Period $period)
    {
        $previous_ends_at= new Carbon($period->ends_at);
        $new_start_at = new Carbon($this->start_at);

        abort_if($previous_ends_at->greaterThan($new_start_at),
            Response::HTTP_BAD_REQUEST,
            "Tu fecha de inicio elegida {$new_start_at->format('d-m-Y')} debe ser mayor que {$previous_ends_at->format('d-m-Y')} la fecha de finalizacion del periodo anterior");

    }

    protected function isStartDateAtGraterThanOrEqualToEndsAt()
    {
        $start_at = new Carbon($this->start_at);
        $ends_at = new Carbon($this->ends_at);

        abort_if($start_at->greaterThanOrEqualTo($ends_at),
            Response::HTTP_BAD_REQUEST,
            "La fecha de inicio {$start_at->format('d-m-Y')} no puede ser mayor que la de finalizacion {$ends_at->format('d-m-Y')}");

    }
}
