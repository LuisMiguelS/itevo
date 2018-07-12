<?php

namespace Tests\Feature\Promotion;

use Tests\TestCase;
use App\{Promotion, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePromotionTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'promotion_no' => 2
    ];

    private $admin;

    private $promotion;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->promotion = factory(Promotion::class)->create(['promotion_no' => 1]);
    }

    /** @test */
    function admin_can_update_promotion()
    {
        $this->actingAs($this->admin)
            ->put($this->promotion->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Promocion no. {$this->defaultData['promotion_no']} actualizada correctamente."]);

        $this->assertDatabaseHas('promotions', $this->withData());
    }

    /** @test */
    function guest_cannot_update_promotion()
    {
        $this->withExceptionHandling();

        $this ->put($this->promotion->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('promotions', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_promotion()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put($this->promotion->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('promotions', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put($this->promotion->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['promotion_no']);

        $this->assertDatabaseMissing('promotions', $this->withData());
    }
}
