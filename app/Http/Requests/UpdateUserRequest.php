<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users,email,'. $this->user->id,
            'institutes' => 'required|array'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'institutes' => 'instituto'
        ];
    }

    public function updateUser(User $user)
    {
        $user->update($this->validated());
        $user->institutes()->detach();
        if (isset($this->validated()['institutes'])){
            $user->institutes()->attach($this->validated()['institutes']);
        }
        return "Usuario {$user->name} actualizado con exito.";
    }
}
