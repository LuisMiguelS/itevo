<?php

namespace App\Http\Requests\UserManagement;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'roles.*' => 'nullable|present'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'roles*' => 'roles'
        ];
    }

    public function createUser()
    {
        $user = User::create($this->validated());
       if (isset($this->validated()['roles'])){
           foreach ($this->validated()['roles'] as $role) {
               $user->assign($role);
           }
       }
        return "Usuario {$user->name} creado con éxito.";
    }
}
