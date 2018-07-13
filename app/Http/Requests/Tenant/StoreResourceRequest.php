<?php

namespace App\Http\Requests\Tenant;

use App\BranchOffice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResourceRequest extends FormRequest
{
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
            'name' => [
                'required',
                'min:4',
                'max:50',
                Rule::unique('type_courses')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                    ]);
                }),
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function createResource(BranchOffice $branchOffice)
    {
        $resource = $branchOffice->resources()->create($this->validated());
        return "Recurso {$resource->name} creado con éxito.";
    }
}
