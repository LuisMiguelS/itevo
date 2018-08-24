<?php

namespace Tests\Feature\Resource;

use Tests\TestCase;
use App\{BranchOffice, Resource, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteResourceTest extends TestCase
{
    use RefreshDatabase;

    private $resource;

    private $user;

    private $admin;

    private $branchOffice;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = factory(Resource::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
        $this->branchOffice = factory(BranchOffice::class)->create();
    }

    /** @test */
        function an_admin_can_soft_delete_resource()
    {
        $this->actingAs($this->admin)
            ->delete( $this->resource->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Recurso {$this->resource->name} enviado a la papelera con éxito."]);

        $this->assertSoftDeleted('resources', [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ]);
    }

    /** @test */
    function an_admin_cannot_soft_delete_resource_from_another_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->delete(route('tenant.resources.trash.destroy', [
                'branchOffice' => $this->branchOffice,
                'resource' => $this->resource
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('resources', [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_soft_delete_resource()
    {
        $this->withExceptionHandling();

        $this->delete( $this->resource->url->trash)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('resources', [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_soft_delete_resource()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->delete( $this->resource->url->trash)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('resources', [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ]);
    }
}
