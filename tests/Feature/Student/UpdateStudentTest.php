<?php

namespace Tests\Feature\Student;

use Carbon\Carbon;
use Tests\TestCase;
use App\{User, Student, BranchOffice};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateStudentTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Cristian',
        'last_name' => 'Gomez',
        'id_card' => '999-9999999-9',
        'phone' => '(809) 999-7643',
        'address' => 'Rep. Dominicana, La vega',
        'birthdate' => '3/7/1996'
    ];

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
    function an_admins_can_update_students()
    {
        $this->actingAs($this->admin)
            ->put($this->student->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Estudiante {$this->defaultData['name']} {$this->defaultData['last_name']} actualizado con éxito."]);

        $this->assertDatabaseHas('students', $this->withData([
            'birthdate' => new Carbon($this->defaultData['birthdate'])
        ]));
    }

    /** @test */
    function an_admin_cannot_update_student_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put(route('tenant.teachers.update', [
                'branchOffice' => factory(BranchOffice::class)->create(),
                'student' => $this->student
            ]),  $this->withData())
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('students', [
            'id' =>  $this->student->id,
            'name' =>  $this->student->name,
            'last_name' =>  $this->student->last_name
        ]);
    }

    /** @test */
    function a_guest_cannot_update_students()
    {
        $this->withExceptionHandling();

        $this->put($this->student->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('students', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_student()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put($this->student->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('students', $this->withData());
    }

    /** @test */
    function it_can_see_student_update_validations_errors()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put($this->student->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'last_name', 'phone', 'address']);

        $this->assertDatabaseHas('students', [
            'id' => $this->student->id,
            'id_card' => $this->student->id_card
        ]);
    }

    /** @test */
    function a_student_id_card_must_be_unique_in_form_update()
    {
        $this->withExceptionHandling();

        $student = factory(Student::class)->create(['branch_office_id' => $this->student->promotion->branchOffice]);

        $this->actingAs($this->admin)
            ->put($this->student->url->update, $this->withData([
                'id_card' => $student->id_card
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['id_card']);

        $this->assertDatabaseMissing('students', $this->withData([
            'id_card' => $student->id_card
        ]));
    }

    /** @test */
    function a_student_phone_must_be_unique_in_form_update()
    {
        $this->withExceptionHandling();

        $student = factory(Student::class)->create(['branch_office_id' => $this->student->promotion->branchOffice]);

        $this->actingAs($this->admin)
            ->put($this->student->url->update, $this->withData([
                'phone' => $student->phone
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['phone']);

        $this->assertDatabaseMissing('students', $this->withData([
            'phone' => $student->phone
        ]));
    }
}
