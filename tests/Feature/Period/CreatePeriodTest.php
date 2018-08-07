<?php

namespace Tests\Feature\Period;

use Carbon\Carbon;
use Tests\TestCase;
use App\{Period, Promotion, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePeriodTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'period' => Period::PERIOD_NO_1,
        'start_date_at' => '3/7/2018',
        'ends_at' => '3/8/2018',
    ];

    private $admin;

    private $user;

    private $promotion;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->promotion = factory(Promotion::class)->create();
    }

    /** @test */
    function admins_can_create_period()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.promotions.periods.store', [
                'branchOffice' => $this->promotion->branchOffice,
                'promotion' => $this->promotion
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Periodo creado correctamente."]);

        $this->assertDatabaseHas('periods', $this->withData([
            'start_date_at' => new Carbon($this->defaultData['start_date_at']),
            'ends_at' => new Carbon($this->defaultData['ends_at']),
        ]));
    }
}
