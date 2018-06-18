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
            'name' => 'required|min:1|max:50'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function createClassRoom ()
    {
        $institute = Classroom::create($this->validated());

        return "Aula {$institute->name} creado con éxito.";
    }
}
