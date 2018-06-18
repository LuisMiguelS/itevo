<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{Classroom, User, Institute};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateClassroomTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Aula 100',
        'building' => 'Edificio J'
    ];

    private $admin;

    private $institute;

    private $classroom;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->institute = factory(Institute::class)->create();
        $this->classroom = factory(Classroom::class)->create();
    }


    /** @test */
    function an_admin_can_update_classroom()
    {
        $this->actingAs($this->admin)
            ->put(route('classrooms.update', $this->classroom), $this->withData([
                'institute_id' => $this->institute->id
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Aula {$this->defaultData['name']} actualizada con éxito."]);

        $this->assertDatabaseHas('classrooms', $this->withData([
            'institute_id' => $this->institute->id
        ]));
    }

    /** @test */
    function an_guest_cannot_update_classroom()
    {
        $this->withExceptionHandling();

        $this->put(route('classrooms.update', $this->classroom), $this->withData([
            'institute_id' => $this->institute->id
        ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_classroom()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('classrooms.update', $this->classroom), $this->withData([
                'institute_id' => $this->institute->id
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put(route('classrooms.update', $this->classroom), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'building', 'institute_id']);

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }
}
