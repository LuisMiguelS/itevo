<?php

namespace Tests\Feature\Period;

use Carbon\Carbon;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use App\{User, Period, Promotion, BranchOffice};
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePeriodTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'period_no' => Period::PERIOD_NO_2,
        'status' => Period::STATUS_FINISHED,
        'start_at' => '3/7/2018',
        'ends_at' => '3/8/2018',
    ];

    /**
     * @var \App\User
     */
    private $admin;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Promotion
     */
    private $promotion;

    /**
     * @var \App\Period
     */
    private $period;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->promotion = factory(Promotion::class)->create();
        $this->period = factory(Period::class)->create([
            'period_no' => Period::PERIOD_NO_1,
            'status' => Period::STATUS_WITHOUT_STARTING,
        ]);
    }

    /** @test */
    function admins_can_update_period()
    {
        $this->actingAs($this->admin)
            ->put(route('tenant.promotions.periods.update', [
                'branchOffice' => $this->period->promotion->branchOffice,
                'promotion' => $this->period->promotion,
                'period' => $this->period
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Periodo {$this->period->period} actualizado correctamente."]);

        $this->assertDatabaseHas('periods', $this->withData([
            'id' => $this->period->id,
            'start_at' => (new Carbon($this->defaultData['start_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }

    /** @test */
    function admins_cannot_update_period_if_use_a_promotion_that_is_not_in_the_actual_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put(route('tenant.promotions.periods.update', [
                'promotion' => $this->period->promotion,
                'branchOffice' => factory(BranchOffice::class)->create(),
                'period' => $this->period
            ]), $this->withData())
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseMissing('periods', $this->withData([
            'start_at' => (new Carbon($this->defaultData['start_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }

    /** @test */
    function guest_cannot_update_period()
    {
        $this->withExceptionHandling();

        $this->put(route('tenant.promotions.periods.update', [
            'promotion' => $this->period->promotion,
            'branchOffice' => factory(BranchOffice::class)->create(),
            'period' => $this->period
        ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('periods', $this->withData([
            'start_at' => (new Carbon($this->defaultData['start_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }

    /** @test */
    function an_unauthorized_user_cannot_update_period()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('tenant.promotions.periods.update', [
                'promotion' => $this->period->promotion,
                'branchOffice' => factory(BranchOffice::class)->create(),
                'period' => $this->period
            ]), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('periods', $this->withData([
            'start_at' => (new Carbon($this->defaultData['start_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }

    /** @test */
    function it_cannot_update_period_if_status_is_finished()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create([
            'status' => Period::STATUS_FINISHED
        ]);

        $this->actingAs($this->admin)
            ->put(route('tenant.promotions.periods.update', [
                'branchOffice' => $period->promotion->branchOffice,
                'promotion' => $period->promotion,
                'period' => $period
            ]), $this->withData())
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseMissing('periods', $this->withData([
            'id' => $this->period->id,
            'start_at' => (new Carbon($this->defaultData['start_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }

    /** @test */
    function it_cannot_change_status_witout_stating_in_period_if_status_is_current()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create([
            'status' => Period::STATUS_CURRENT
        ]);

        $this->actingAs($this->admin)
            ->put(route('tenant.promotions.periods.update', [
                'branchOffice' => $period->promotion->branchOffice,
                'promotion' => $period->promotion,
                'period' => $period
            ]), $this->withData([
                'status' => Period::STATUS_WITHOUT_STARTING,
            ]))
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('periods', $this->withData([
            'id' => $period->id,
            'status' => Period::STATUS_CURRENT
        ]));
    }

    /** @test */
    function it_cannot_change_date_start_and_finish_in_period_if_status_is_current()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create([
            'status' => Period::STATUS_CURRENT
        ]);

        $this->actingAs($this->admin)
            ->put(route('tenant.promotions.periods.update', [
                'branchOffice' => $period->promotion->branchOffice,
                'promotion' => $period->promotion,
                'period' => $period
            ]), $this->withData([
                'status' => Period::STATUS_WITHOUT_STARTING,
            ]))
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('periods', $this->withData([
            'id' => $period->id,
            'status' => Period::STATUS_CURRENT,
            'start_at' => $period->start_at->toDateTimeString(),
            'ends_at' => $period->ends_at->toDateTimeString(),
        ]));
    }

    /** @test */
    function it_can_see_validations_errors_on_form_period()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put(route('tenant.promotions.periods.update', [
                'promotion' => $this->period->promotion,
                'branchOffice' => factory(BranchOffice::class)->create(),
                'period' => $this->period
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['period_no', 'start_at', 'ends_at']);

        $this->assertDatabaseMissing('periods', $this->withData([
            'start_at' => (new Carbon($this->defaultData['start_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }
}
