<?php

namespace Tests\Feature\course;

use Tests\TestCase;
use App\{Course, BranchOffice, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseTest extends TestCase
{
    use RefreshDatabase;

    private $course;

    private $user;

    private $admin;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->course = factory(Course::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }

    /** @test */
    function an_admin_can_soft_delete_course()
    {
        $this->actingAs($this->admin)
            ->delete($this->course->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Curso {$this->course->name} enviado a la papelera con éxito."]);

        $this->assertSoftDeleted('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }

    /** @test */
    function an_admin_cannot_soft_delete_course_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->delete(route('tenant.courses.trash.destroy', [
                'branchOffice' => $this->branchOffice,
                'courses' => $this->course
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_soft_delete_course()
    {
        $this->withExceptionHandling();

        $this->delete($this->course->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_soft_delete_course()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->delete($this->course->url->trash)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'name' => $this->course->name,
        ]);
    }
}
