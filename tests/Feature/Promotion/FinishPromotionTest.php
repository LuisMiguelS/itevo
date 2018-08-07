<?php

namespace Tests\Feature\Promotion;

use App\Promotion;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinishPromotionTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    private $promotion;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->promotion = factory(Promotion::class)->create(['promotion_no' => 1]);
    }

    /** @test */
    function admin_can_finish_promotion()
    {
        $this->actingAs($this->admin)
            ->get($this->promotion->url->finish)
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('promotions', [
            'id' => $this->promotion->id,
            'promotion_no' => $this->promotion->promotion_no,
            'status' => Promotion::STATUS_FINISHED
        ]);
    }
}
