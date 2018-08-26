<?php

namespace App\Http\Requests\Tenant;

use Carbon\Carbon;
use App\{BranchOffice, Schedule};
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSchedulesRequest extends FormRequest
{
    private  $min_diffInHours = 1;
    private  $max_diffInHours = 6;

    private $hour_range_start = "07:00:00";
    private $hour_range_finish = "21:00:00";

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
            'weekday' => [
                'required',
                Rule::in([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY, Schedule::SATURDAY, Schedule::SUNDAY]),
            ],
            'start_at' => [
                'required',
                Rule::unique('schedules')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['start_at', $this->start_at],
                        ['ends_at', $this->ends_at],
                    ]);
                }),
            ],
            'ends_at' => [
                'required',
                Rule::unique('schedules')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['start_at', $this->start_at],
                        ['ends_at', $this->ends_at],
                    ]);
                }),
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'weekday' => 'días laborables',
            'start_at' => 'hora de inicio',
            'ends_at' => 'hora de finalizacion',
        ];
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return string
     */
    public function createSchedule(BranchOffice $branchOffice)
    {
        $branchOffice->schedules()->create($this->getFields());
        return 'Horario creado con éxito.';
    }

    /**
     * @return array
     */
    protected function getFields()
    {
        $start_at = new Carbon($this->start_at);
        $ends_at = new Carbon($this->ends_at);

        $this->extraValidation($start_at, $ends_at);

        return [
            'weekday' => $this->weekday,
            'start_at' =>  $start_at->toDateTimeString(),
            'ends_at' => $ends_at->toDateTimeString()
        ];
    }

    /**
     * @param \Carbon\Carbon $start_at
     * @param \Carbon\Carbon $ends_at
     */
    protected function extraValidation(Carbon $start_at, Carbon $ends_at)
    {
        abort_if($start_at->greaterThan($ends_at),
            Response::HTTP_BAD_REQUEST,
            "La fecha de inicio [{$start_at->toDateTimeString()}] no puede ser menor que la fecha de finalización [{$ends_at->toDateTimeString()}]");

        abort_if($start_at->diffInHours($ends_at) < $this->min_diffInHours,
            Response::HTTP_BAD_REQUEST,
            "Para crear el horario debe haber almenos {$this->min_diffInHours} hora de diferencia [hay {$start_at->diffInHours($ends_at)}] entre la fecha de inicio [{$start_at->toDateTimeString()}] y la fecha de finalizacion [{$ends_at->toDateTimeString()}]");

        abort_if($start_at->diffInHours($ends_at) > $this->max_diffInHours,
            Response::HTTP_BAD_REQUEST,
            "Para crear el horario debe haber menos de {$this->max_diffInHours} hora de diferencia [hay {$start_at->diffInHours($ends_at)}] entre la fecha de inicio [{$start_at->toDateTimeString()}] y la fecha de finalizacion [{$ends_at->toDateTimeString()}]");

        abort_unless($this->validHourRange($start_at) && $this->validHourRange($ends_at),
            Response::HTTP_BAD_REQUEST,
        "El rango de hora del horario debe ser entre {$this->hour_range_start} : {$this->hour_range_finish}, Tu rango elegido es invalido {$start_at->toTimeString()} : {$ends_at->toTimeString()}"
        );

    }

    /**
     * @param \Carbon\Carbon $hour
     * @return bool
     */
    protected function validHourRange(Carbon $hour)
    {
        return $hour->toTimeString() > $this->hour_range_start && $hour->toTimeString() < $this->hour_range_finish;
    }
}
