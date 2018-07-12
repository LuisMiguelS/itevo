<?php

namespace Tests\Feature\Promotion;

use App\Period;
use App\User;
use Tests\TestCase;
use App\BranchOffice;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePromotionTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'promotion_no' => 1,
    ];

    private $admin;

    private $branchOffice;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }

    /** @test */
    function admin_can_create_promotion()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.promotions.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Promocion No. {$this->defaultData['promotion_no']} creada correctamente."]);

        $this->assertDatabaseHas('promotions', [
            'promotion_no' => 1
        ]);

        $this->assertDatabaseHas('periods', [
            'status' => Period::STATUS_CURRENT,
            'period' => Period::PERIOD_NO_1,
        ]);
    }

    /** @test */
    function guest_cannot_create_promotion()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.promotions.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('promotions', [
            'promotion_no' => 1
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_create_promotion()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('tenant.promotions.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('promotions');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('tenant.promotions.store', $this->branchOffice), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['promotion_no']);

        $this->assertDatabaseEmpty('promotions');
    }
}
