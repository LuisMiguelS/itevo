<?php

namespace Tests\Feature\Classroom;

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
            ->put(route('tenant.classrooms.update', [
                'institute' => $this->institute,
                'classroom' => $this->classroom
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Aula {$this->defaultData['name']} actualizada con éxito."]);

        $this->assertDatabaseHas('classrooms', $this->withData());
    }

    /** @test */
    function an_guest_cannot_update_classroom()
    {
        $this->withExceptionHandling();

        $this->put(route('tenant.classrooms.update', [
                'institute' => $this->institute,
                'classroom' => $this->classroom
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_classroom()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('tenant.classrooms.update', [
                'institute' => $this->institute,
                'classroom' => $this->classroom
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put(route('tenant.classrooms.update', [
                'institute' => $this->institute,
                'classroom' => $this->classroom
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'building']);

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }
}
