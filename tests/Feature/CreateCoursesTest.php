<?php

namespace Tests\Feature;

use App\{Institute, User};
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCoursesTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Curso de Arte',
    ];

    protected function setUp()
    {
        parent::setUp();
    }

    /** @test */
    function an_admin_can_create_classrooms()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function an_guest_cannot_create_classroom()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function an_unauthorized_user_cannot_create_institute()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->markTestIncomplete();
    }
}
