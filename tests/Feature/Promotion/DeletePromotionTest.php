<?php

namespace Tests\Feature\Promotion;

use App\Promotion;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePromotionTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    private $promotion;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->promotion = factory(Promotion::class)->create([
            'promotion_no' => 1,
            'status' => Promotion::STATUS_CURRENT
        ]);
    }

    /** @test */
    function promotion_status_change_to_finish_if_soft_delete()
    {
        $this->actingAs($this->admin)
            ->delete($this->promotion->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Promocion {$this->promotion->promotion_no} enviado a la papelera con éxito."]);

        $this->assertSoftDeleted('promotions', [
            'id' => $this->promotion->id,
            'status' => Promotion::STATUS_FINISHED
        ]);
    }
}
