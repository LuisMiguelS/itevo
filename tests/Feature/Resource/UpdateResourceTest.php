<?php

namespace Tests\Feature\Resource;

use Tests\TestCase;
use App\{BranchOffice, User, Resource};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateResourceTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Diplomado',
        'price' => 200,
        'necessary' => \App\Resource::NECESSARY
    ];

    private $admin;

    private $resource;

    private $user;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->resource = factory(Resource::class)->create();
        $this->user = factory(User::class)->create();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }


    /** @test */
    function an_admin_can_update_resource()
    {
        $this->actingAs($this->admin)
            ->put($this->resource->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Recurso {$this->defaultData['name']} actualizado con éxito."]);

        $this->assertDatabaseHas('resources', $this->withData([
            'name' => strtolower('Diplomado'),
        ]));
    }


    /** @test */
    function an_admin_cannot_update_resource_from_another_branchOffice()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put(route('tenant.resources.update', [
                'branchOffice' => $this->branchOffice,
                'resource' => $this->resource
            ]), $this->withData())
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('resources', [
            'id' => $this->resource->id,
            'name' => strtolower($this->resource->name),
        ]);
    }

    /** @test */
    function an_guest_cannot_update_resource()
    {
        $this->withExceptionHandling();

        $this->put($this->resource->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('resources', $this->withData([
            'name' => strtolower('Diplomado'),
        ]));
    }

    /** @test */
    function an_unauthorized_user_cannot_update_resource()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put($this->resource->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('resources', $this->withData([
            'name' => strtolower('Diplomado'),
        ]));
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put($this->resource->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('resources', $this->withData([
            'name' => strtolower('Diplomado'),
        ]));
    }
}
