<?php

namespace Tests\Feature;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use App\{Course, CoursePeriod, Resource, Student};
use Illuminate\Foundation\Testing\RefreshDatabase;

class InscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\User */
    private $admin;

    /** @var \App\Course */
    private $course;

    /** @var \App\CoursePeriod */
    private $coursePeriod;

    /** @var \App\Resource */
    private $resource;

    /** @var \App\Student */
    private $student;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();

        $this->course = factory(Course::class)->create();

        $this->coursePeriod = factory(CoursePeriod::class)->create([
            'course_id' =>  $this->course->id
        ]);

        $this->resource = factory(Resource::class)->create([
            'name' => 'Inscripcion',
            'price' => 200.00,
            'branch_office_id' =>  $this->coursePeriod->course->branchOffice->id
        ]);

        $this->coursePeriod->addResources([$this->resource->id]);

        $this->student = factory(Student::class)->create([
            'branch_office_id' =>  $this->coursePeriod->course->branchOffice->id
        ]);
    }

    /** @test */
    function admins_can_enroll_a_student()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.inscription.store',  $this->coursePeriod->course->branchOffice), [
                'course_period' => [
                    $this->coursePeriod,
                ],
                'resources' => [
                    $this->resource
                ],
                'student_id' => $this->student->id,
                'paid_out' => 200,
                'cash_received' => 500,
            ])->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('course_period_student', [
            'course_period_id' => $this->coursePeriod->id,
            'student_id' => $this->student->id,
        ]);

        $this->assertDatabaseHas('invoices', [
            'student_id' => $this->student->id,
        ]);

        $this->assertDatabaseHas('invoicables', [
            'invoicable_type' => 'App\\CoursePeriod',
            'invoicable_id' => $this->coursePeriod->id
        ]);

        $this->assertDatabaseHas('invoicables', [
            'invoicable_type' => 'App\\Resource',
            'invoicable_id' => $this->resource->id
        ]);

        $this->assertDatabaseHas('payments', [
            'payment_amount' => 200,
            'cash_received' => 500,
        ]);
    }
}
