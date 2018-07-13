<?php

namespace App\Http\Requests\Tenant;

use App\Resource;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResourceRequest extends FormRequest
{
    public function authorize ()
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
                Rule::unique('type_courses')->ignore($this->resource->id)->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                    ]);
                }),
            ]
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function updateResource (Resource $resource)
    {
        $resource->update($this->validated());
        return "Recurso {$resource->name} actualizado con éxito.";
    }
}
