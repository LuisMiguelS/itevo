<?php

namespace App\Http\Requests\Tenant;

use App\Resource;
use Illuminate\Foundation\Http\FormRequest;

class StoreResourceRequest extends FormRequest
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

    public function createResource ()
    {
        $resource = Resource::create($this->validated());

        return "Recurso {$resource->name} creado con éxito.";
    }
}
