<?php

namespace Tests\Feature\Course;

use Tests\TestCase;
use App\{BranchOffice, TypeCourse, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCoursesTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Curso De Arte',
    ];

    private $type_course;

    private $admin;

    private $user;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->type_course = factory(TypeCourse::class)->create();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }

    /** @test */
    function an_admin_can_create_course()
    {
       $this->actingAs($this->admin)
           ->post(route('tenant.courses.store', $this->branchOffice), $this->withData([
               'type_course_id' => $this->type_course->id
           ]))
           ->assertStatus(Response::HTTP_FOUND)
           ->assertSessionHas(['flash_success'=> "Curso {$this->defaultData['name']} creado con éxito."]);

       $this->assertDatabaseHas('courses', [
           'name' => 'curso de arte',
       ]);
    }

    /** @test */
    function an_guest_cannot_create_course()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.courses.store', $this->branchOffice), $this->withData([
                'type_course_id' => $this->type_course->id
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseEmpty('courses');
    }

    /** @test */
    function an_unauthorized_user_cannot_create_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('tenant.courses.store', $this->branchOffice), $this->withData([
                'type_course_id' => $this->type_course->id
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('courses');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('tenant.courses.store', $this->branchOffice), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'type_course_id']);

        $this->assertDatabaseEmpty('courses');
    }
}
