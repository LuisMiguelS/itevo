<?php

namespace Tests\Feature\typecourse;

use App\User;
use Tests\TestCase;
use App\TypeCourse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTypeCourseTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Diplomado',
    ];

    private $admin;

    private $type_course;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->type_course = factory(TypeCourse::class)->create();
        $this->user = factory(User::class)->create();
    }


    /** @test */
    function an_admin_can_update_type_course()
    {
        $this->actingAs($this->admin)
            ->put(route('typecourses.update', $this->type_course), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Tipo de curso {$this->defaultData['name']} actualizado con éxito."]);

        $this->assertDatabaseHas('type_courses', $this->withData());
    }

    /** @test */
    function an_guest_cannot_update_type_course()
    {
        $this->withExceptionHandling();

        $this->put(route('typecourses.update', $this->type_course), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('type_courses', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_typecourse()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('typecourses.update', $this->type_course), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('type_courses', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put(route('typecourses.update', $this->type_course), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('type_courses', $this->withData());
    }
}
