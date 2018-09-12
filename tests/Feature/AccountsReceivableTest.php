<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{Course, CoursePeriod, Invoice, Resource, Student};
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountsReceivableTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    private $course;

    private $coursePeriod;

    private $resource;

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

        $this->enrollStudent();
    }

    /** @test */
    function admins_can_charge_account_receivable()
    {
        $invoice = Invoice::query()
            ->orderByDesc('id')
            ->first();

        $this->actingAs($this->admin)
            ->post(route('tenant.accounts_receivable.store', $this->coursePeriod->course->branchOffice), [
                'invoice_id' => $invoice->id,
                'resources' => [],
                'paid_out' => $paid_out = (int) $invoice->total - $invoice->balance,
                'cash_received' => $paid_out + 100,
            ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => Invoice::STATUS_COMPLETE
        ]);

        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'payment_amount' => $paid_out = (int) $invoice->total - $invoice->balance,
            'cash_received' => $paid_out + 100,
        ]);
    }


    protected function enrollStudent()
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
            ]);
    }
}
