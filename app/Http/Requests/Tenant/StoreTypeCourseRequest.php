<?php

namespace App\Http\Requests\Tenant;

use App\BranchOffice;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTypeCourseRequest extends FormRequest
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

    public function createTypeCourse(BranchOffice $branchOffice)
    {
        $type_course = $branchOffice->typecourses()->create($this->validated());
        return "Tipo de curso {$type_course->name} creado con éxito.";
    }
}
