<?php

namespace Tests\Feature\Course;

use Tests\TestCase;
use App\{Institute, User, Course};
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

    private $institute;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->course = factory(Course::class)->create();
        $this->user = factory(User::class)->create();
        $this->institute = factory(Institute::class)->create();
    }


    /** @test */
    function an_admin_can_update_course()
    {
        $this->actingAs($this->admin)
            ->put(route('tenant.courses.update', [
                'institute' => $this->institute,
                'courses' => $this->course
            ]), $this->withData([
                'type_course_id' => $this->course->type_course_id
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Curso {$this->defaultData['name']} actualizado con éxito."]);

        $this->assertDatabaseHas('courses', $this->withData([
            'type_course_id' => $this->course->type_course_id
        ]));
    }

    /** @test */
    function an_guest_cannot_update_course()
    {
        $this->withExceptionHandling();

        $this->put(route('tenant.courses.update', [
            'institute' => $this->institute,
            'courses' => $this->course
        ]), $this->withData([
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
            ->put(route('tenant.courses.update', [
                'institute' => $this->institute,
                'courses' => $this->course
            ]), $this->withData([
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
            ->put(route('tenant.courses.update', [
                'institute' => $this->institute,
                'courses' => $this->course
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'type_course_id']);

        $this->assertDatabaseMissing('courses', $this->withData([
            'type_course_id' => $this->course->type_course_id
        ]));
    }
}
