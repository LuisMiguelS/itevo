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
            'name' => 'required|min:1|max:50'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function updateClassRoom (Classroom $classroom)
    {
        $classroom->update($this->validated());

        return "Aula {$classroom->name} actualizada con éxito.";
    }
}
