<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers;

    protected $defaultData = [];

    protected function setUp()
    {
        parent::setUp();
        $this->seed('BouncerSeeder');
        $this->withoutExceptionHandling();
    }
}
