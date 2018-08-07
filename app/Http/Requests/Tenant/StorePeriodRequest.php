<?php

namespace App\Http\Requests\Tenant;

use App\BranchOffice;
use App\Period;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

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
            'period' => 'in:' .Period::PERIOD_NO_1. ',' .Period::PERIOD_NO_2. ',' .Period::PERIOD_NO_3,
            'start_date_at' => 'required|date',
            'ends_at' => 'required|date',
        ];
    }

    public function createPeriod(Promotion $promotion)
    {
        $promotion->periods()->create($this->getFields($promotion));
        return "Periodo creado correctamente.";
    }

    protected function getFields(Promotion $promotion)
    {
        $previous_period = $promotion->periods()->orderByDesc('id')->first();

        $this->isLastPeriodEndsAtGreater($previous_period);

        $this->isStartDateAtGraterThanOrEqualToEndsAt();

        $data = $this->validated();
        $data['start_date_at'] = new Carbon($this->validated()['start_date_at']);
        $data['ends_at'] = new Carbon($this->validated()['ends_at']);
        return $data;
    }

    /**
     * @param $previous_period
     */
    protected function isLastPeriodEndsAtGreater($previous_period): void
    {
        if ($previous_period) {
            $previous_period_ends_at = new Carbon($previous_period->start_date_at);
            $period_start_date_at = new Carbon($this->validated()['start_date_at']);

            if ($previous_period_ends_at->greaterThan($period_start_date_at)) {
                abort(400, 'Debes elegir una fecha de inicio mayor que la fecha de finalizacion del periodo anterior');
            }
        }
    }

    protected function isStartDateAtGraterThanOrEqualToEndsAt(): void
    {
        $start_date_at = new Carbon($this->validated()['start_date_at']);
        $ends_at = new Carbon($this->validated()['ends_at']);
        if ($start_date_at->greaterThanOrEqualTo($ends_at)) {
            abort(400, 'La fecha de inicio no puede ser mayor que la de finalizacion');
        }
    }
}
