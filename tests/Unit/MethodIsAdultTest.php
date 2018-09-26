<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MethodIsAdultTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_is_an_adult()
    {
        $this->assertTrue($this->isAdult('1996-7-3 23:26:11.223'));
        $this->assertFalse($this->isAdult(Carbon::now()));
    }

    protected function isAdult($birthday)
    {
        return (new Carbon($birthday))->age >= 18;
    }
}
