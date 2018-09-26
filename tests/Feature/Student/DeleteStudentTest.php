<?php

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\{BranchOffice, User, Student};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteStudentTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    private $user;

    private $student;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->student = factory(Student::class)->create();
    }

    /** @test */
    function an_admin_can_soft_delete_student()
    {
        $this->actingAs($this->admin)
            ->delete($this->student->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Estudiante {$this->student->full_name} enviado a la papelera con éxito."]);

        $this->assertSoftDeleted('students', [
            'id' => $this->student->id,
            'name' => strtolower($this->student->name),
        ]);
    }

    /** @test */
    function an_admin_cannot_soft_delete_student_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->delete(route('tenant.students.trash.destroy', [
                'branchOffice' => factory(BranchOffice::class)->create(),
                'teacher' => $this->student
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('students', [
            'id' => $this->student->id,
            'name' => strtolower($this->student->name),
        ]);
    }

    /** @test */
    function an_guest_cannot_soft_delete_student()
    {
        $this->withExceptionHandling();

        $this->delete($this->student->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('students', [
            'id' => $this->student->id,
            'name' => strtolower($this->student->name),
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_soft_delete_student()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->delete($this->student->url->trash)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('students', [
            'id' => $this->student->id,
            'name' => strtolower($this->student->name),
        ]);
    }
}
