<?php

namespace App\Http\Requests\Tenant;

use App\Teacher;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            'id_card' => [
                'required',
                'min:13',
                'max:13',
                'unique:teachers,id_card,'. $this->teacher->id,
                Rule::unique('teachers')->ignore($this->teacher->id)->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['id_card', $this->request->get('id_card')],
                    ]);
                })
            ],
            'name' => 'required|min:4',
            'last_name' => 'required|min:4',
            'phone' => [
                'min:9',
                'max:17',
                'required',
                'unique:teachers,phone,'. $this->teacher->id,
                Rule::unique('teachers')->ignore($this->teacher->id)->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['phone', $this->request->get('phone')],
                    ]);
                })
            ]
        ];
    }

    public function attributes ()
    {
        return [
            'id_card' => 'cédula',
            'name' => 'nombre (s)',
            'last_name' => 'apellido (s)',
            'phone' => 'teléfono',
        ];
    }

    public function updateTeacher(Teacher $teacher)
    {
        $teacher->update($this->validated());
        return "Profesor {$teacher->full_name} actualizado correctamente.";
    }
}
