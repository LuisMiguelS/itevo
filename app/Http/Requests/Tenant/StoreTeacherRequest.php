<?php

namespace App\Http\Requests\Tenant;

use App\BranchOffice;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
                'unique:teachers',
                Rule::unique('teachers')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['id_card', $this->request->get('id_card')],
                    ]);
                })
            ],
            'name' => 'required',
            'last_name' => 'required',
            'phone' => [
                'required',
                'min:9',
                'max:17',
                'unique:teachers',
                Rule::unique('teachers')->where(function ($query) {
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

    public function createTeacher(BranchOffice $branchOffice)
    {
        $teacher = $branchOffice->teachers()->create($this->validated());
        return "Profesor {$teacher->full_name} creado correctamente.";
    }
}
