<?php

namespace App\Http\Requests;

use App\Classroom;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRoomRequest extends FormRequest
{
    public function authorize ()
    {
        return true;
    }

    public function rules ()
    {
        return [
            'name' => 'required|min:1|max:50',
            'building' => 'required|min:1|max:50',
            'institute_id' => 'required|numeric',
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'building' => 'nombre del edificio',
            'institute_id' => 'instituto'
        ];
    }

    public function updateClassRoom (Classroom $classroom)
    {
        $classroom->update($this->validated());

        return "Aula {$classroom->name} actualizada con éxito.";
    }
}
