<?php

namespace Tests\Feature\BranchOffice;

use Tests\TestCase;
use App\{User, BranchOffice};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateBranchOfficeTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Itevo La Vega',
    ];

    private $branchOffice;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->branchOffice = factory(BranchOffice::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_update_branch_office()
    {
        $this->actingAs($this->admin)
            ->put($this->branchOffice->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Sucursal {$this->defaultData['name']} actualizado con exito."]);

        $this->assertDatabaseHas('branch_offices', $this->withData([
            'id' => $this->branchOffice->id
        ]));
    }

    /** @test */
    function an_guest_cannot_update_branch_office()
    {
        $this->withExceptionHandling();

        $this->put($this->branchOffice->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('branch_offices', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_branchOffice()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put($this->branchOffice->url->update, $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('branch_offices', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put($this->branchOffice->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('branch_offices', $this->withData());
    }
}
