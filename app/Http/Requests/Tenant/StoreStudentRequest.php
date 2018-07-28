<?php

namespace App\Http\Requests\Tenant;

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
                'max:13',
                Rule::unique('students')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['tutor_id_card', $this->request->get('tutor_id_card')],
                    ]);
                }),
            ],
            'phone' => [
                'required',
                'min:9',
                'max:17',
                Rule::unique('students')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['phone', $this->request->get('phone')],
                    ]);
                }),
            ],
            'is_adult' => [
                'required',
                Rule::in([true, false]),
                ],
            'birthdate' => 'nullable|date',
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
            'is_adult' => 'es adulto',
            'address' => 'direccion',
            'birthdate' => 'fecha de nacimiento',
        ];
    }

    public function createStudent(BranchOffice $branchOffice)
    {
        abort_unless($branchOffice->currentPromotion() 
            && $this->there_is_some_registered_id_card($this->validated()), 422, 'Registraste mal los datos :/');

        $fileds = $this->validated();
        $fileds['promotion_id'] = $branchOffice->currentPromotion()->id;
        $estudiante = $branchOffice->students()->create($fileds);
        return "Estudiante {$estudiante->full_name} creado correctamente.";
    }

    public function there_is_some_registered_id_card($data)
    {
        if ((isset($data['id_card']) && $data['id_card'] === null) || (isset($data['tutor_id_card']) && $data['tutor_id_card'] === null))
            false;

        return true;
    }
}
