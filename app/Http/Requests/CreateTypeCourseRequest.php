<?php

namespace App\Http\Requests;

use App\TypeCourse;
use Illuminate\Foundation\Http\FormRequest;

class CreateTypeCourseRequest extends FormRequest
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
            'name' => 'required|min:4|max:50|unique:type_courses'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function createTypeCourse()
    {
        $type_course = TypeCourse::create($this->validated());
        return "Tipo de curso {$type_course->name} creado con éxito.";
    }
}
