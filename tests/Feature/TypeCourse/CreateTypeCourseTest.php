<?php

namespace Tests\Feature\TypeCourse;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTypeCourseTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Maestria',
    ];

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_create_type_courses()
    {
        $this->actingAs($this->admin)
            ->post(route('typecourses.store'), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Tipo de curso {$this->defaultData['name']} creado con éxito."]);

        $this->assertDatabaseHas('type_courses', $this->withData());
    }

    /** @test */
    function an_guest_cannot_create_type_courses()
    {
        $this->withExceptionHandling();

        $this->post(route('typecourses.store'), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('type_courses', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_create_type_courses()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('typecourses.store'), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('type_courses');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('typecourses.store'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseEmpty('type_courses');
    }
}
