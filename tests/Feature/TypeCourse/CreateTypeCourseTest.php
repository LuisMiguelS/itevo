<?php

namespace Tests\Feature\TypeCourse;

use Tests\TestCase;
use App\{User, Institute};
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
        $this->institute = factory(Institute::class)->create();
    }

    /** @test */
    function an_admin_can_create_type_courses()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.typecourses.store', $this->institute), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Tipo de curso {$this->defaultData['name']} creado con éxito."]);

        $this->assertDatabaseHas('type_courses', $this->withData());
    }

    /** @test */
    function an_guest_cannot_create_type_courses()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.typecourses.store', $this->institute), $this->withData())
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
            ->post(route('tenant.typecourses.store', $this->institute), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('type_courses');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('tenant.typecourses.store', $this->institute), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseEmpty('type_courses');
    }
}
