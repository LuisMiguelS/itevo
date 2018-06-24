<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Silber\Bouncer\Database\Role;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required',
            'abilities.*' => 'nullable|present'
        ];
    }

    public function createRole()
    {
        $role = Role::create($this->validated());
        if (isset($this->validated()['abilities'])) {
            $role->allow($this->validated()['abilities']);
        }
        return "Rol {$role->title} creado con éxito";
    }
}
