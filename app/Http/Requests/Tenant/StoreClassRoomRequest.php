<?php

namespace App\Http\Requests\Tenant;

use App\BranchOffice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClassRoomRequest extends FormRequest
{
    public function authorize ()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:1',
                'max:50',
                Rule::unique('classrooms')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                        ['building', $this->request->get('building')],
                    ]);
                }),
            ],
            'building' => [
                'required',
                'min:1',
                'max:50',
                Rule::unique('classrooms')->where(function ($query) {
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
            'name' => 'nombre del aula',
            'building' => 'nombre del edificio',
        ];
    }

    public function createClassRoom(BranchOffice $branchOffice)
    {
        $classroon = $branchOffice->classrooms()->create($this->validated());
        return "Aula {$classroon->name} creado con éxito.";
    }
}
