<?php

namespace Tests\Feature\Schedule;

use Tests\TestCase;
use App\{Schedule, User, BranchOffice};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'weekday' => 'lunes',
        'start_at' => '2018-08-23 07:52:11',
        'ends_at' => '2018-08-23 08:52:11',
    ];

    private $admin;

    private $user;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }

    /** @test */
    function admin_can_create_schedule()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.schedules.store', [
                'branchOffice' => $this->branchOffice,
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => 'Horario creado con éxito.']);

        $this->assertDatabaseHas('schedules', $this->withData());
    }

    /** @test */
    function schedule_cannot_create_if_ends_at_is_greater_than_start_at()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.schedules.store', [
                'branchOffice' => $this->branchOffice,
            ]), $this->withData([
                'start_at' => '2018-08-23 09:00:00',
                'ends_at' => '2018-08-22 09:00:00',
            ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('schedules');
    }

    /** @test */
    function the_minimun_hour_of_the_schedule_must_be_one_hour()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.schedules.store', [
                'branchOffice' => $this->branchOffice,
            ]), $this->withData([
                'start_at' => '2018-08-23 09:00:00',
                'ends_at' => '2018-08-23 09:30:00',
            ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('schedules');
    }

    /** @test */
    function the_max_hour_of_the_schedule_must_be_six_hour()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.schedules.store', [
                'branchOffice' => $this->branchOffice,
            ]), $this->withData([
                'start_at' => '2018-08-23 01:00:00',
                'ends_at' => '2018-08-23 09:00:00',
            ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('schedules');
    }

    /** @test */
    function the_schedule_cannot_created_in_a_different_hour_range_lower_than_07_00()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.schedules.store', [
                'branchOffice' => $this->branchOffice,
            ]), $this->withData([
                'start_at' => '2018-08-23 05:00:00',
                'ends_at' => '2018-08-23 09:00:00',
            ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('schedules');
    }

    /** @test */
    function the_schedule_cannot_created_in_a_different_hour_range_above_than_21_00()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.schedules.store', [
                'branchOffice' => $this->branchOffice,
            ]), $this->withData([
                'start_at' => '2018-08-23 20:00:00',
                'ends_at' => '2018-08-23 23:00:00',
            ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('schedules');
    }
}
