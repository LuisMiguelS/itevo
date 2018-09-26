<?php

namespace Tests\Feature\Student;

use Carbon\Carbon;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use App\{BranchOffice, Promotion, Student, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStudentTest extends TestCase
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

    private $promotion;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->promotion = factory(Promotion::class)->create(['promotion_no' => 1]);
        $this->user = factory(User::class)->create();
    }

    /** @test */
    function an_admins_can_create_student()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.students.store', $this->promotion->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Estudiante {$this->defaultData['name']} {$this->defaultData['last_name']} creado correctamente."]);

        $this->assertDatabaseHas('students', $this->withData([
            'birthdate' => new Carbon($this->defaultData['birthdate']),
            'name' => 'cristian',
            'last_name' => 'gomez',
        ]));
    }

    /** @test */
    function a_guest_cannot_create_student()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.students.store', $this->promotion->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseEmpty('students');
    }

    /** @test */
    function an_unauthorized_user_cannot_create_student()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('tenant.students.store', $this->promotion->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('students');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.students.store', $this->promotion->branchOffice), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'last_name', 'phone', 'address']);

        $this->assertDatabaseEmpty('students');
    }

    /** @test */
    function a_student_id_card_must_be_unique_in_form_store()
    {
        $this->withExceptionHandling();

        $student = factory(Student::class)->create();

        $this->actingAs($this->admin)
            ->post(route('tenant.students.store', $student->promotion->branchOffice), $this->withData([
                'id_card' => $student->id_card
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['id_card']);

        $this->assertDatabaseMissing('students', $this->withData([
            'id_card' => $student->id_card,
            'name' => 'cristian',
            'last_name' => 'gomez',
        ]));
    }


    /** @test */
    function a_student_cannot_create_if_promotion_not_exists()
    {
        $this->withExceptionHandling();

        $branchOffice = factory(BranchOffice::class)->create();

        $this->actingAs($this->admin)
            ->post(route('tenant.students.store', $branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseMissing('students', $this->withData([
            'name' => 'cristian',
            'last_name' => 'gomez',
        ]));
    }

    /** @test */
    function a_student_cannot_create_if_not_have_id_card_or_tutor_id_card()
    {
        $this->withExceptionHandling();

        $branchOffice = factory(BranchOffice::class)->create();

        $this->actingAs($this->admin)
            ->post(route('tenant.students.store', $branchOffice), $this->withData([
                'id_card' => null
            ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseMissing('students', $this->withData([
            'name' => 'cristian',
            'last_name' => 'gomez',
        ]));
    }
}
