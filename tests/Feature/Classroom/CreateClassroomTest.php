<?php

namespace Tests\Feature\Classroom;

use App\{Institute, User};
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateClassroomTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Aula 100',
        'building' => 'Edificio J'
    ];

    private $admin;

    private $institute;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->institute = factory(Institute::class)->create();
    }

    /** @test */
    function an_admin_can_create_classrooms()
    {
        $this->actingAs($this->admin)
            ->post(route('classrooms.store'), $this->withData([
                'institute_id' => $this->institute->id
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Aula {$this->defaultData['name']} creado con éxito."]);

        $this->assertDatabaseHas('classrooms', $this->withData([
            'institute_id' => $this->institute->id
        ]));
    }

    /** @test */
    function an_guest_cannot_create_classroom()
    {
        $this->withExceptionHandling();

        $this->post(route('classrooms.store'), $this->withData([
            'institute_id' => $this->institute->id
        ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('classrooms', $this->withData([
            'institute_id' => $this->institute->id
        ]));
    }

    /** @test */
    function an_unauthorized_user_cannot_create_institute()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('classrooms.store'), $this->withData([
                'institute_id' => $this->institute->id
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('classrooms');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('classrooms.store'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'building', 'institute_id']);

        $this->assertDatabaseEmpty('classrooms');
    }
}
