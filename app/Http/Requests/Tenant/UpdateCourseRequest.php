<?php

namespace App\Http\Requests\Tenant;

use App\Course;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
                'min:2',
                'max:255',
                Rule::unique('courses')->ignore($this->course->id)->where(function ($query) {
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
                Rule::unique('courses')->ignore($this->course->id)->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['name', $this->request->get('name')],
                        ['type_course_id', $this->request->get('type_course_id')],
                    ]);
                }),
            ]
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'type_course_id' => 'tipo de curso'
        ];
    }

    public function updateCourse(Course $course)
    {
        $course->update($this->validated());
        return "Curso {$course->name} actualizado con éxito.";
    }
}
