<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, CoursePeriod, Student};
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

class InscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(BranchOffice $branchOffice)
    {
        return view('tenant.inscription.index')
            ->with(['branchOffice' => $branchOffice]);
    }

    public function store(BranchOffice $branchOffice)
    {
        $course_period = CoursePeriod::findOrFail(request('course_period_id'));
        $student = Student::findOrFail(request('student_id'));

        abort_unless($course_period->course->branchOffice->id === $branchOffice->id, 400);

        abort_unless($student->branchOffice->id === $branchOffice->id, 400);

        return DB::transaction(function () use ($course_period, $student){

            if ($student->signed_up === null) {
                $student->signed_up = Carbon::now();
                $student->save();
            }

            $course_period->students()->attach($student->id);

            $course_period_student = DB::table('course_period_student')
                ->where('course_period_id', $course_period->id)
                ->orderByDesc('id')
                ->first();

            $payment_id = DB::table('payments')->insertGetId([
                'course_period_student_id' => $course_period_student->id,
                'total' => $course_period->totalCourse(),
                'paid_out' => request('paid_out')
            ]);

            DB::table('transactions')->insertGetId([
                'payment_id' => $payment_id,
                'paid_out' => request('paid_out'),
                'cash_received' =>  request('cash_received'),
                'description' => 'pago...'
            ]);

            return $payment_id;
        });
    }

    public function students(BranchOffice $branchOffice)
    {
        return response()->json(['data' => $branchOffice->students], 200);
    }

    public function courses(BranchOffice $branchOffice)
    {
        return response()->json(['data' =>
            $branchOffice->currentPromotion()
            ->currentPeriod()
            ->coursePeriods()
            ->with('teacher', 'course', 'classroom', 'schedules', 'resources')
            ->get()
        ], 200);
    }
}
