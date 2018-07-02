<?php

namespace Tests\Feature\Course;

use Tests\TestCase;
use App\{BranchOffice, User, Course};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCourseTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Diplomado',
    ];

    private $admin;

    private $course;

    private $user;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->course = factory(Course::class)->create();
        $this->user = factory(User::class)->create();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }


    /** @test */
    function an_admin_can_update_course()
    {
        $this->actingAs($this->admin)
            ->put($this->course->url->update, $this->withData([
                'type_course_id' => $this->course->type_course_id
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Curso {$this->defaultData['name']} actualizado con éxito."]);

        $this->assertDatabaseHas('courses', $this->withData([
            'type_course_id' => $this->course->type_course_id
        ]));
    }

    /** @test */
    function an_admin_cannot_update_course_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put(route('tenant.courses.update', [
                'branchOffice' => $this->branchOffice,
                'course' => $this->course
            ]), $this->withData([
                'type_course_id' => $this->course->type_course_id
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_update_course()
    {
        $this->withExceptionHandling();

        $this->put($this->course->url->update, $this->withData([
            'type_course_id' => $this->course->type_course_id
        ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('courses', $this->withData([
            'type_course_id' => $this->course->type_course_id
        ]));
    }

    /** @test */
    function an_unauthorized_user_cannot_update_course()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put($this->course->url->update, $this->withData([
                'type_course_id' => $this->course->type_course_id
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('courses', $this->withData([
            'type_course_id' => $this->course->type_course_id
        ]));
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put($this->course->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'type_course_id']);

        $this->assertDatabaseMissing('courses', $this->withData([
            'type_course_id' => $this->course->type_course_id
        ]));
    }
}
