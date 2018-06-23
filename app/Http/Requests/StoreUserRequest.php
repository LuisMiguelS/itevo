<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'institutes' => 'required|array'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'institutes' => 'instituto'
        ];
    }

    public function createUser()
    {
        $user = User::create($this->validated());
        $user->assign(User::ROLE_TENANT_ADMIN);
        $user->institutes()->attach($this->validated()['institutes']);
        return "Usuario {$user->name} creado con éxito.";
    }

}
