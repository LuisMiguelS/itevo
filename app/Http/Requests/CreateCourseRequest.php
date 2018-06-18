<?php

namespace App\Http\Requests;

use App\Course;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
{
    public function authorize ()
    {
        return true;
    }

    public function rules ()
    {
        return [
            'name' => 'required|min:2|max:255',
            'type' => 'required|min:2|max:100'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'type' => 'tipo'
        ];
    }

    public function createCourse ()
    {
        $course = Course::create($this->validated());

        return "Curso {$course->name} creado con éxito.";
    }
}
