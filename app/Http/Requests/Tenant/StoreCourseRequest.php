<?php

namespace App\Http\Requests\Tenant;

use App\BranchOffice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
                'min:2',
                'max:255',
                Rule::unique('courses')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                        ['type_course_id', $this->request->get('type_course_id')],
                    ]);
                }),
            ],
            'type_course_id' => [
                'required',
                'numeric',
                Rule::unique('courses')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                        ['type_course_id', $this->request->get('type_course_id')],
                    ]);
                }),
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'type_course_id' => 'tipo de curso'
        ];
    }

    public function createCourse(BranchOffice $branchOffice)
    {
        $course = $branchOffice->courses()->create($this->validated());
        return "Curso {$course->name} creado con éxito.";
    }
}
