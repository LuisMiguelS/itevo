<?php

namespace App\Http\Requests\Tenant;

use App\Course;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize ()
    {
        return true;
    }

    public function rules ()
    {
        return [
            'name' => 'required|min:2|max:255',
            'type_course_id' => 'required|numeric'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'type_course_id' => 'tipo de curso'
        ];
    }

    public function createCourse ()
    {
        $course = Course::create($this->validated());
        return "Curso {$course->name} creado con éxito.";
    }
}
