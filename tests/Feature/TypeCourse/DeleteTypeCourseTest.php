<?php

namespace Tests\Feature\type_course;

use Tests\TestCase;
use App\{Institute, TypeCourse, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTypeCourseTest extends TestCase
{
    use RefreshDatabase;

    private $type_course;

    private $user;

    private $admin;

    private $institute;

    protected function setUp()
    {
        parent::setUp();
        $this->type_course = factory(TypeCourse::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
        $this->institute = factory(Institute::class)->create();
    }

    /** @test */
        function an_admin_can_delete_type_course()
    {
        $this->actingAs($this->admin)
            ->delete(route('tenant.typecourses.destroy', [
                'institute' => $this->institute,
                'typeCourse' => $this->type_course
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Tipo de curso {$this->type_course->name} eliminado con éxito."]);

        $this->assertSoftDeleted('type_courses', [
            'id' => $this->type_course->id,
            'name' => $this->type_course->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_type_course()
    {
        $this->withExceptionHandling();

        $this->delete(route('tenant.typecourses.destroy', [
            'institute' => $this->institute,
            'typeCourse' => $this->type_course
        ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('type_courses', [
            'id' => $this->type_course->id,
            'name' => $this->type_course->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_type_course()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('tenant.typecourses.destroy', [
                'institute' => $this->institute,
                'typeCourse' => $this->type_course
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('type_courses', [
            'id' => $this->type_course->id,
            'name' => $this->type_course->name,
        ]);
    }
}
