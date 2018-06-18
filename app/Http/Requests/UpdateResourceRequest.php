<?php

namespace App\Http\Requests;

use App\Resource;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResourceRequest extends FormRequest
{
    public function authorize ()
    {
        return true;
    }

    public function rules ()
    {
        return [
            'name' => 'required|min:2|max:50'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function updateResource (Resource $resource)
    {
        $resource->update($this->validated());

        return "Recurso {$resource->name} actualizada con éxito.";
    }
}
