<?php

namespace App\Http\Requests\Tenant;

use App\Institute;
use Illuminate\Foundation\Http\FormRequest;

class StoreClassRoomRequest extends FormRequest
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
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre del aula',
            'building' => 'nombre del edificio',
        ];
    }

    public function createClassRoom(Institute $institute)
    {
        $classroon = $institute->classrooms()->create($this->validated());
        return "Aula {$classroon->name} creado con éxito.";
    }
}
