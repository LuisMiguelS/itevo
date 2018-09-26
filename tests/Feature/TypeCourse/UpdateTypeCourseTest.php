<?php

namespace Tests\Feature\TypeCourse;

use Tests\TestCase;
use App\{BranchOffice, User, TypeCourse};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTypeCourseTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'diplomado',
    ];

    private $admin;

    private $type_course;

    private $user;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->type_course = factory(TypeCourse::class)->create();
        $this->user = factory(User::class)->create();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }


    /** @test */
    function an_admin_can_update_type_course()
    {
        $this->actingAs($this->admin)
            ->put($this->type_course->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Tipo de curso Diplomado actualizado con éxito."]);

        $this->assertDatabaseHas('type_courses', $this->withData());
    }


    /** @test */
    function an_admin_cannot_update_type_course_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put(route('tenant.typeCourses.update', [
                'branchOffice' => $this->branchOffice,
                'typeCourse' => $this->type_course
            ]), $this->withData())
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('type_courses', [
            'id' => $this->type_course->id,
            'name' => strtolower($this->type_course->name),
        ]);
    }

    /** @test */
    function an_guest_cannot_update_type_course()
    {
        $this->withExceptionHandling();

        $this->put($this->type_course->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('type_courses', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_type_course()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put($this->type_course->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('type_courses', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put($this->type_course->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('type_courses', $this->withData());
    }
}
