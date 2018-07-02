<?php

namespace Tests\Feature\Resource;

use Tests\TestCase;
use App\{User, BranchOffice};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateResourceTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Inscripcion',
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
    function an_admin_can_create_resource()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.resources.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Recurso {$this->defaultData['name']} creado con éxito."]);

        $this->assertDatabaseHas('resources', $this->withData());
    }

    /** @test */
    function an_guest_cannot_create_resources()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.resources.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('resources', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_create_resources()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('tenant.resources.store', $this->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('resources');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('tenant.resources.store', $this->branchOffice), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseEmpty('resources');
    }
}
