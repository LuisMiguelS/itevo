<?php

namespace Tests\Feature\TypeCourse;

use Tests\TestCase;
use App\{BranchOffice, TypeCourse, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTypeCourseTest extends TestCase
{
    use RefreshDatabase;

    private $type_course;

    private $user;

    private $admin;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->type_course = factory(TypeCourse::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }

    /** @test */
        function an_admin_can_soft_delete_type_course()
    {
        $this->actingAs($this->admin)
            ->delete($this->type_course->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Tipo de curso {$this->type_course->name} enviado a la papelera con éxito."]);

        $this->assertSoftDeleted('type_courses', [
            'id' => $this->type_course->id,
            'name' => strtolower($this->type_course->name),
        ]);
    }

    /** @test */
    function an_admin_cannot_soft_delete_type_course_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->delete(route('tenant.typeCourses.trash.destroy', [
                'branchOffice' => $this->branchOffice,
                'typeCourse' => $this->type_course
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('type_courses', [
            'id' => $this->type_course->id,
            'name' => strtolower($this->type_course->name),
        ]);
    }

    /** @test */
    function an_guest_cannot_soft_delete_type_course()
    {
        $this->withExceptionHandling();

        $this->delete($this->type_course->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('type_courses', [
            'id' => $this->type_course->id,
            'name' => strtolower($this->type_course->name),
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_soft_delete_type_course()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->delete($this->type_course->url->trash)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('type_courses', [
            'id' => $this->type_course->id,
            'name' => strtolower($this->type_course->name),
        ]);
    }
}
