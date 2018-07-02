<?php

namespace Tests\Feature\Classroom;

use Tests\TestCase;
use App\{Classroom, User, BranchOffice};
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

    private $brachOffice;

    private $classroom;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->brachOffice = factory(BranchOffice::class)->create();
        $this->classroom = factory(Classroom::class)->create();
    }


    /** @test */
    function an_admin_can_update_classroom()
    {
        $this->actingAs($this->admin)
            ->put($this->classroom->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Aula {$this->defaultData['name']} actualizada con éxito."]);

        $this->assertDatabaseHas('classrooms', $this->withData());
    }

    /** @test */
    function an_admin_cannot_update_classroom_from_another_brach_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put(route('tenant.classrooms.update', [
                'brachOffice' => factory(BranchOffice::class)->create(),
                'classrooms' => $this->classroom
            ]), $this->withData())
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('classrooms', [
            'id' => $this->classroom->id,
            'name' => $this->classroom->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_update_classroom()
    {
        $this->withExceptionHandling();

        $this->put($this->classroom->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_classroom()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put($this->classroom->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put($this->classroom->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'building']);

        $this->assertDatabaseMissing('classrooms', $this->withData());
    }
}
