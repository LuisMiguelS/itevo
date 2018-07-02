<?php

namespace Tests\Feature\Classroom;

use Tests\TestCase;
use App\{BranchOffice, User};
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

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }

    /** @test */
    function an_admin_can_create_classrooms()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.classrooms.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Aula {$this->defaultData['name']} creado con éxito."]);

        $this->assertDatabaseHas('classrooms', $this->withData([
            'branch_office_id' => $this->branchOffice->id
        ]));
    }

    /** @test */
    function an_guest_cannot_create_classroom()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.classrooms.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('classrooms', $this->withData([
            'branch_office_id' => $this->branchOffice->id
        ]));
    }

    /** @test */
    function an_unauthorized_user_cannot_create_branchOffice()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('tenant.classrooms.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('classrooms');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('tenant.classrooms.store', $this->branchOffice), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'building']);

        $this->assertDatabaseEmpty('classrooms');
    }
}
