<?php

namespace Tests\Feature\Command;

use Carbon\Carbon;
use Tests\TestCase;
use App\{Institute, Promotion};
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromotionCommandTest extends TestCase
{
    use RefreshDatabase;

    private $institute;

    protected function setUp()
    {
        parent::setUp();
        $this->institute = factory(Institute::class)->create();
    }

    /** @test */
    function its_cannot_create_duplicate_promotion_period_for_the_institutes()
    {
        Carbon::setTestNow(Carbon::parse('January 1 2018'));

        Artisan::call('promotion:setup');
        Artisan::call('promotion:setup');
        Artisan::call('promotion:setup');

        $this->assertCount(1, collect(Promotion::count()));
    }

    /** @test */
    function promotion_current_change_status_when_new_promotion_period_is_create()
    {
        Carbon::setTestNow(Carbon::parse('January 1 2018'));

        Artisan::call('promotion:setup');

        $this->assertDatabaseHas('promotions', [
            'period' => Promotion::PROMOTION_NO_1,
            'status' => Promotion::STATUS_INSCRIPTION,
            'institute_id' => $this->institute->id,
            'created_at' => "2018-01-01 00:00:00",
        ]);

        Carbon::setTestNow(Carbon::parse('May 1 2018'));

        Artisan::call('promotion:setup');

        $this->assertDatabaseHas('promotions', [
            'period' => Promotion::PROMOTION_NO_1,
            'status' => Promotion::STATUS_FINISHED,
            'institute_id' => $this->institute->id,
            'created_at' => "2018-01-01 00:00:00",
        ]);

        $this->assertDatabaseHas('promotions', [
            'period' => Promotion::PROMOTION_NO_2,
            'status' => Promotion::STATUS_INSCRIPTION,
            'institute_id' => $this->institute->id,
            'created_at' => "2018-05-01 00:00:00",
        ]);
    }

    /** @test */
    function its_create_the_promotion_of_period_1_for_all_the_corresponding_institutes()
    {
        Carbon::setTestNow(Carbon::parse('January 1 2018'));

        Artisan::call('promotion:setup');

        $this->assertDatabaseHas('promotions', [
            'period' => Promotion::PROMOTION_NO_1,
            'status' => Promotion::STATUS_INSCRIPTION,
            'institute_id' => $this->institute->id
        ]);
    }

    /** @test */
    function its_change_status_to_current_for_the_promotion_of_period_1_for_all_the_corresponding_institutes()
    {
        Carbon::setTestNow(Carbon::parse('January 1 2018'));

        Artisan::call('promotion:setup');

        Carbon::setTestNow(Carbon::parse('January 16 2018'));

        Artisan::call('promotion:setup');

        $this->assertDatabaseHas('promotions', [
            'period' => Promotion::PROMOTION_NO_1,
            'status' => Promotion::STATUS_CURRENT,
            'institute_id' => $this->institute->id
        ]);
    }

    /** @test */
    function its_create_the_promotion_of_period_2_for_all_the_corresponding_institutes()
    {
        Carbon::setTestNow(Carbon::parse('May 1'));

        Artisan::call('promotion:setup');

        $this->assertDatabaseHas('promotions', [
            'period' => Promotion::PROMOTION_NO_2,
            'status' => Promotion::STATUS_INSCRIPTION,
            'institute_id' => $this->institute->id
        ]);
    }

    /** @test */
    function its_create_the_promotion_of_period_3_for_all_the_corresponding_institutes()
    {
        Carbon::setTestNow(Carbon::parse('September 1'));

        Artisan::call('promotion:setup');

        $this->assertDatabaseHas('promotions', [
            'period' => Promotion::PROMOTION_NO_3,
            'status' => Promotion::STATUS_INSCRIPTION,
            'institute_id' => $this->institute->id
        ]);
    }
}
