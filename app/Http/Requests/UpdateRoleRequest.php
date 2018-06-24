<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Silber\Bouncer\Database\Role;

class UpdateRoleRequest extends FormRequest
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

    public function updateRole(Role $role)
    {
        $role->update($this->validated());

        foreach ($role->getAbilities() as $ability) {
            $role->disallow($ability->id);
        }

        if (isset($this->validated()['abilities'])) {
            $role->allow($this->validated()['abilities']);
        }

        return "Rol {$role->title} actualizado con éxito.";
    }
}
