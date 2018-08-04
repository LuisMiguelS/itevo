<?php

namespace App\Http\Requests\Tenant;

use App\Classroom;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('classrooms')->ignore($this->classroom->id)->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                        ['building', $this->request->get('building')],
                    ]);
                }),
            ],
            'building' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('classrooms')->ignore($this->classroom->id)->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                        ['building', $this->request->get('building')],
                    ]);
                }),
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'building' => 'nombre del edificio',
        ];
    }

    public function updateClassRoom(Classroom $classroom)
    {
        $classroom->update($this->validated());
        return "Aula {$classroom->name} actualizada con éxito.";
    }
}
