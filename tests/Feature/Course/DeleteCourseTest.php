<?php

namespace Tests\Feature\course;

use Tests\TestCase;
use App\{
    Course, TypeCourse, User
};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseTest extends TestCase
{
    use RefreshDatabase;

    private $course;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->course = factory(Course::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
        function an_admin_can_delete_type_course()
    {
        $this->actingAs($this->admin)
            ->delete(route('courses.destroy', $this->course))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Curso {$this->course->name} eliminado con éxito."]);

        $this->assertSoftDeleted('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_type_course()
    {
        $this->withExceptionHandling();

        $this->delete(route('courses.destroy', $this->course))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_type_course()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('courses.destroy', $this->course))
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }
}
