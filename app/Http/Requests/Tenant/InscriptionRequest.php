<?php

namespace App\Http\Requests\Tenant;

use DB;
use Carbon\Carbon;
use App\{CoursePeriod, Resource, Student};
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InscriptionRequest extends FormRequest
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
            'student_id' => 'required',
            'course_period' => 'required|array',
            'resources' => 'required|array',
            'paid_out' => 'required|numeric',
            'cash_received' => 'required|numeric',
        ];
    }

    public function createInscription(\App\BranchOffice $branchOffice)
    {
        $invoice = DB::transaction(function () use ($branchOffice){
            $student = tap(Student::findOrFail(request('student_id')), function ($student) {
                if ($student->signed_up === null) {
                    $student->signed_up = Carbon::now();
                    $student->save();
                }

                if ($student->notes !== null) {
                    $student->notes = null;
                    $student->save();
                }
            });

            return tap($student->invoices()->create(), function ($invoice) use ($student) {
                collect(request('course_period'))->unique('id')->each(function ($course_period) use ($student, $invoice) {
                    $active_course = CoursePeriod::findOrFail($course_period['id']);
                    try{
                        $active_course->students()->attach($student->id);
                    }catch (\Exception $e) {
                        throw new HttpException(400, 'No puede registrar un estudiante que ya ha sido registrado en el curso');
                    }
                    $invoice->coursePeriod()->attach($active_course->id,  ['price' => $active_course->price]);
                });

                collect(request('resources'))->unique('id')->each(function ($resources) use ($student, $invoice) {
                    $resource = Resource::findOrFail($resources['id']);
                    $invoice->resources()->attach($resource->id,  ['price' => $resource->price]);
                });
            });
        });

        $invoice->payments()->create([
            'payment_amount' => $this->paid_out,
            'cash_received' => $this->cash_received
        ]);

        return $invoice;
    }
}
