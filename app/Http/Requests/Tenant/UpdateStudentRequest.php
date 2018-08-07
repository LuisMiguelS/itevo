<?php

namespace App\Http\Requests\Tenant;

use App\Student;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
                Rule::unique('students')->ignore($this->student->id)->where(function ($query) {
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
            ],
            'phone' => [
                'required',
                'min:14',
                'max:14',
                Rule::unique('students')->ignore($this->student->id)->where(function ($query) {
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

    public function updateStudent(Student $student)
    {
        $student->update($this->getFields($this->validated()));
        return "Estudiante {$student->full_name} actualizado con éxito.";
    }

    public function getFields($data)
    {
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
