<?php

namespace App\Http\Requests\Tenant;

use App\Student;
use Carbon\Carbon;
use App\BranchOffice;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|min:3|max:70',
            'last_name' => 'required|min:4|max:70',
            'id_card' => [
                'nullable',
                'min:13',
                'max:13',
                Rule::unique('students')->where(function ($query) {
                    return $query->where([
                        ['branch_office_id', $this->branchOffice->id],
                        ['id_card', $this->request->get('id_card')],
                    ]);
                }),
            ],
            'tutor_id_card' => [
                'nullable',
                'min:13',
                'max:13',
                'required_if:id_card,==,null'
            ],
            'phone' => [
                'required',
                'min:14',
                'max:14',
            ],
            'birthdate' => 'required|date',
            'address' => 'required|min:15|max:255'
        ];
    }

    public function attributes ()
    {
        return [
            'id_card' => 'cédula',
            'tutor_id_card' => 'cédula del tutor',
            'name' => 'nombre (s)',
            'last_name' => 'apellido (s)',
            'phone' => 'teléfono',
            'address' => 'direccion',
            'birthdate' => 'fecha de nacimiento',
        ];
    }

    public function createStudent(BranchOffice $branchOffice)
    {
        $estudiante = $branchOffice->students()->create($this->getFields($branchOffice));
        return "Estudiante {$estudiante->full_name} creado correctamente.";
    }

    public function getFields(BranchOffice $branchOffice)
    {
       $this->additionalValidationFields($branchOffice);

        $data = $this->validated();
        $data['promotion_id'] = $branchOffice->currentPromotion()->id;
        $data['birthdate'] = (new Carbon($this->validated()['birthdate']))->toDateTimeString();
        $data['tutor_id_card'] = $this->isAdult(new Carbon($this->validated()['birthdate'])) ? null : $this->validated()['tutor_id_card'];

        return $data;
    }


    protected function additionalValidationFields(BranchOffice $branchOffice): void
    {
        abort_unless($branchOffice->currentPromotion(), 400, 'No hay una promocion actual');

        if ($this->isAdult(new Carbon($this->validated()['birthdate']))){
            abort_if(isset($this->validated()['id_card'])
                && $this->validated()['id_card'] == null, 400, 'Debe especificar la cedula, si el estudiante es mayor de edad');
        }

        abort_if(isset($this->validated()['tutor_id_card'])
            && $this->validated()['tutor_id_card'] == null, 400, 'Debe especificar la cedula del tutor, si el estudiante no es mayor de edad');
    }

    protected function isAdult(Carbon $birthday)
    {
        return $birthday->age >= config('itevo.adulthood');
    }


}
