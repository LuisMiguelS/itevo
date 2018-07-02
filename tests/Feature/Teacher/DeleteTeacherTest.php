<?php

namespace Tests\Feature\BranchOffice;

use Tests\TestCase;
use App\{Teacher, User, BranchOffice};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTeacherTest extends TestCase
{
    use RefreshDatabase;

    private $teacher;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->teacher = factory(Teacher::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_delete_teacher()
    {
        $this->actingAs($this->admin)
            ->delete($this->teacher->url->delete)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Profesor {$this->teacher->full_name} eliminado con exito."]);

        $this->assertSoftDeleted('teachers', [
            'id' => $this->teacher->id,
            'name' => $this->teacher->name,
        ]);
    }

    /** @test */
    function an_admin_cannot_delete_teacher_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->delete(route('tenant.teachers.destroy', [
                'branchOffice' => factory(BranchOffice::class)->create(),
                'teacher' => $this->teacher
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('teachers', [
            'id' => $this->teacher->id,
            'name' => $this->teacher->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_teacher()
    {
        $this->withExceptionHandling();

        $this->delete($this->teacher->url->delete)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('teachers', [
            'id' => $this->teacher->id,
            'name' => $this->teacher->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_teacher()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->delete($this->teacher->url->delete)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('teachers', [
            'id' => $this->teacher->id,
            'name' => $this->teacher->name,
        ]);
    }
}
