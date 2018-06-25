<?php

namespace App\Http\Requests\Tenant;

use App\Teacher;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            'id_card' => 'required|unique:teachers,id_card,'. $this->teacher->id,
            'name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:teachers,phone,'. $this->teacher->id,
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

    public function updateTeacher(Teacher $teacher)
    {
        $teacher->update($this->validated());
        return "Profesor {$teacher->full_name} actualizado correctamente.";
    }
}
