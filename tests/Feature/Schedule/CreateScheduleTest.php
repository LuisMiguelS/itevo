<?php

namespace Tests\Feature\Schedule;

use App\User;
use Tests\TestCase;
use App\BranchOffice;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'start_at' => '3/7/2018',
        'ends_at' => '3/8/2018',
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
    function admins_can_create_schedule()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.schedules.store', [
                'branchOffice' => $this->branchOffice,
            ]), $this->withData())
            ->assertStatus(Response::HTTP_OK);
    }
}
