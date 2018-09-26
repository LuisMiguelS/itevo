<?php

namespace Tests\Feature\CoursePeriod;

use Tests\TestCase;
use App\{CoursePeriod, Schedule, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddScheduleTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    private $user;

    private $coursePeriod;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->coursePeriod = factory(CoursePeriod::class)->create();
    }

    /** @test */
    function admin_can_add_schedule_to_course_period()
    {
        $schedules = factory(Schedule::class)->times(2)->create([
            'branch_office_id' =>  $this->coursePeriod->period->promotion->branchOffice->id
        ]);

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.schedules', [
                'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
                'period' => $this->coursePeriod->period,
                'coursePeriod' => $this->coursePeriod
            ]), [
                'schedules' => [$schedules[0]->id, $schedules[1]->id]
            ])->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('coursables', [
            'course_period_id' => $this->coursePeriod->id,
            'coursable_type' => 'App\Schedule',
            'coursable_id' => $schedules[0]->id
        ]);

        $this->assertDatabaseHas('coursables', [
            'course_period_id' => $this->coursePeriod->id,
            'coursable_type' => 'App\Schedule',
            'coursable_id' => $schedules[1]->id
        ]);
    }

    /** @test */
    function admin_cannot_add_schedule_to_course_if_other_course_period_have_same_schedule()
    {
        $horario_1 = factory(Schedule::class)->create([
            'branch_office_id' =>  $this->coursePeriod->period->promotion->branchOffice->id
        ]);

        $horario_2 = factory(Schedule::class)->create([
            'branch_office_id' =>  $this->coursePeriod->period->promotion->branchOffice->id
        ]);

        $curso_programacion = factory(CoursePeriod::class)->create([
            'price' => 100.00,
            'period_id' => $this->coursePeriod->period->id
        ]);

        $curso_programacion->addSchedules([$horario_1->id]);

        $this->coursePeriod->addSchedules([$horario_1->id, $horario_2->id]);

        $this->assertDatabaseHas('coursables', [
            'course_period_id' => $curso_programacion->id,
            'coursable_type' => 'App\Schedule',
            'coursable_id' =>  $horario_1->id
        ]);

        $this->assertDatabaseMissing('coursables', [
            'course_period_id' => $curso_programacion->id,
            'coursable_type' => 'App\Schedule',
            'coursable_id' =>  $horario_2->id
        ]);

        $this->assertDatabaseMissing('coursables', [
            'course_period_id' => $this->coursePeriod->id,
            'coursable_type' => 'App\Schedule',
            'coursable_id' =>  $horario_1->id
        ]);

        $this->assertDatabaseHas('coursables', [
            'course_period_id' => $this->coursePeriod->id,
            'coursable_type' => 'App\Schedule',
            'coursable_id' =>  $horario_2->id
        ]);
    }
}
