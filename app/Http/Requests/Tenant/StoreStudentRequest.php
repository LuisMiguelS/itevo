<?php

namespace App\Http\Requests\Tenant;

use Carbon\Carbon;
use App\BranchOffice;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|min:3|max:70',
            'last_name' => 'required|min:4|max:70',
            'id_card' => [
                'nullable',
                'min:13',
                'max:13',
                Rule::unique('students')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['id_card', $this->request->get('id_card')],
                    ]);
                }),
            ],
            'tutor_id_card' => [
                'nullable',
                'min:13',
                'max:13'
            ],
            'phone' => [
                'required',
                'min:14',
                'max:14',
                Rule::unique('students')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['phone', $this->request->get('phone')],
                    ]);
                }),
            ],
            'birthdate' => 'required|date',
            'address' => 'required|min:15|max:255'
        ];
    }

    public function attributes ()
    {
        return [
            'id_card' => 'cédula',
            'tutor_id_card' => 'cédula del tutor',
            'name' => 'nombre (s)',
            'last_name' => 'apellido (s)',
            'phone' => 'teléfono',
            'address' => 'direccion',
            'birthdate' => 'fecha de nacimiento',
        ];
    }

    public function createStudent(BranchOffice $branchOffice)
    {
        $estudiante = $branchOffice->students()->create($this->getFields($branchOffice, $this->validated()));
        return "Estudiante {$estudiante->full_name} creado correctamente.";
    }

    public function getFields(BranchOffice $branchOffice, $data)
    {
        abort_unless($branchOffice->currentPromotion(), 400, 'No hay una promocion actual');

        $data['promotion_id'] = $branchOffice->currentPromotion()->id;
        $data['birthdate'] = new Carbon($data['birthdate']);

        if ($this->isAdult($data['birthdate'])){
            abort_if(isset($data['id_card']) && $data['id_card'] === null, 400, 'Debe especificar la cedula, si el estudiante es mayor de edad');

            $data['tutor_id_card'] = null;

            return $data;
        }

        abort_unless(isset($data['tutor_id_card']) && $data['tutor_id_card'] === null, 400, 'Debe especificar la cedula del tutor, si el estudiante no es mayor de edad');

        return $data;
    }

    protected function isAdult($birthday)
    {
        return $birthday->age >= config('itevo.adulthood');
    }
}
