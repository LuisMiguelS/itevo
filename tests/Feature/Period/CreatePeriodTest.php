<?php

namespace Tests\Feature\Period;

use Carbon\Carbon;
use Tests\TestCase;
use App\{BranchOffice, Period, Promotion, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePeriodTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'period_no' => Period::PERIOD_NO_1,
        'status' => Period::STATUS_WITHOUT_STARTING,
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
            'start_date_at' => (new Carbon($this->defaultData['start_date_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }

    /** @test */
    function admins_cannot_create_period_if_use_a_promotion_that_is_not_in_the_actual_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.promotions.periods.store', [
                'branchOffice' => factory(BranchOffice::class)->create(),
                'promotion' => $this->promotion
            ]), $this->withData())
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseEmpty('periods');
    }

    /** @test */
    function guest_cannot_create_period()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.promotions.periods.store', [
            'branchOffice' => $this->promotion->branchOffice,
            'promotion' => $this->promotion
        ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('periods', $this->withData([
            'start_date_at' => (new Carbon($this->defaultData['start_date_at']))->toDateTimeString(),
            'ends_at' => (new Carbon($this->defaultData['ends_at']))->toDateTimeString(),
        ]));
    }

    /** @test */
    function an_unauthorized_user_cannot_create_period()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('tenant.promotions.periods.store', [
                'branchOffice' => $this->promotion->branchOffice,
                'promotion' => $this->promotion
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('periods');
    }

    /** @test */
    function it_can_see_validations_errors_on_form_period()
    {
        $this->handleValidationExceptions();

       $this->actingAs($this->admin)
            ->post(route('tenant.promotions.periods.store', [
                'branchOffice' => $this->promotion->branchOffice,
                'promotion' => $this->promotion
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['period_no', 'start_date_at', 'ends_at']);

        $this->assertDatabaseEmpty('periods');
    }

}
