<?php

namespace App\Http\Requests\Tenant;

use App\TypeCourse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTypeCourseRequest extends FormRequest
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
                Rule::unique('type_courses')->ignore($this->typeCourse->id)->where(function ($query) {
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

    public function updateTypeCourse(TypeCourse $typeCourse)
    {
        $typeCourse->update($this->validated());
        return "Tipo de curso {$typeCourse->name} actualizado con éxito.";
    }
}
