<?php

namespace App\Http\Requests;

use App\BranchOffice;
use Illuminate\Foundation\Http\FormRequest;

class CreateBranchOfficeRequest extends FormRequest
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
            'name' => 'required|min:4|max:100'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre'
        ];
    }

    public function createBranchOffice()
    {
        $branchOffice = BranchOffice::create($this->validated());
        return "Sucursal {$branchOffice->name} creado con exito.";
    }
}
