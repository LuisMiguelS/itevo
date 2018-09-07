<?php

namespace App\Http\Requests;

use App\BranchOffice;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateBranchOfficeRequest extends FormRequest
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
            'name' => 'required|min:4|max:100'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function createBranchOffice()
    {
        $branchOffice = BranchOffice::create($this->validated());
        $this->createResources($branchOffice);
        $this->createSchedules($branchOffice);
        return "Sucursal {$branchOffice->name} creado con exito.";
    }

    public function createResources(BranchOffice $branchOffice)
    {
        $branchOffice->resources()->create([
            'name' => "Inscripción",
            'price' => 200,
            'necessary' => \App\Resource::NECESSARY
        ]);

        $branchOffice->resources()->create([
            'name' => "Graduacion",
            'price' => 200,
            'necessary' => \App\Resource::UNNECESSARY
        ]);
    }

    public function createSchedules(BranchOffice $branchOffice)
    {
        $branchOffice->schedules()->create([
            'weekday' => \App\Schedule::WEEKDAY['saturday'],
            'start_at' => Carbon::createFromTimeString('10:00:00'),
            'ends_at' => Carbon::createFromTimeString('12:00:00'),
        ]);
    }
}
