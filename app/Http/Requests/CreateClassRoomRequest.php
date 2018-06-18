<?php

namespace App\Http\Requests;

use App\Classroom;
use Illuminate\Foundation\Http\FormRequest;

class CreateClassRoomRequest extends FormRequest
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
            'institute_id' => 'required',
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre del aula',
            'building' => 'nombre del edificio',
            'institute_id' => 'instituto'
        ];
    }

    public function createClassRoom ()
    {
        $classroon = Classroom::create($this->validated());
        return "Aula {$classroon->name} creado con éxito.";
    }
}
