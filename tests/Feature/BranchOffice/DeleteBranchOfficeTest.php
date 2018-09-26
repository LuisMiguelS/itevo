<?php

namespace Tests\Feature\BranchOffice;

use Tests\TestCase;
use App\{User, BranchOffice};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteBranchOfficeTest extends TestCase
{
    use RefreshDatabase;

    private $branchOffice;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->branchOffice = factory(BranchOffice::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin =  $this->admin = tap(factory(User::class)->create([
            'email' => 'thepany96@gmail.com'
        ]), function ($user) {
            $user->assign(User::ROLE_ADMIN);
        });
    }

    /** @test */
    function an_super_admin_can_delete_branch_office()
    {
        $this->actingAs($this->admin)
            ->delete($this->branchOffice->url->delete)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Sucursal {$this->branchOffice->name} eliminado con exito."]);

        $this->assertSoftDeleted('branch_offices', [
            'id' => $this->branchOffice->id,
            'name' => strtolower($this->branchOffice->name),
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_branch_office()
    {
        $this->withExceptionHandling();

        $this->delete($this->branchOffice->url->delete)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('branch_offices', [
            'id' => $this->branchOffice->id,
            'name' => strtolower($this->branchOffice->name),
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_branch_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->delete($this->branchOffice->url->delete)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('branch_offices', [
            'id' => $this->branchOffice->id,
            'name' => strtolower($this->branchOffice->name),
        ]);
    }
}
