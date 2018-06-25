<?php

namespace App\Http\Requests\Tenant;

use App\Institute;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'id_card' => 'required|unique:teachers',
            'name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:teachers',
        ];
    }

    public function attributes ()
    {
        return [
            'id_card' => 'cédula',
            'name' => 'nombre (s)',
            'last_name' => 'apellido (s)',
            'phone' => 'teléfono',
        ];
    }

    public function createTeacher(Institute $institute)
    {
        $teacher = $institute->teachers()->create($this->validated());
        return "Profesor {$teacher->full_name} creado correctamente.";
    }
}
