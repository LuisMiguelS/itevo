<?php

namespace Tests\Feature\BranchOffice;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateBranchOfficeTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Itevo La Vega',
    ];

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = tap(factory(User::class)->create([
            'email' => 'thepany96@gmail.com'
        ]), function ($user) {
            $user->assign(User::ROLE_ADMIN);
        });
    }

    /** @test */
    function an_super_admin_can_create_branch_office()
    {
        $this->actingAs($this->admin)
            ->post(route('branchOffices.store'), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Sucursal {$this->defaultData['name']} creado con exito."]);

        $this->assertDatabaseHas('branch_offices', [
            'name' => 'itevo la vega',
            'slug' => 'itevo-la-vega',
        ]);
    }

    /** @test */
    function an_guest_cannot_create_branch_office()
    {
        $this->withExceptionHandling();

        $this->post(route('branchOffices.store'), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('branch_offices', $this->withData( ));
    }

    /** @test */
    function an_unauthorized_user_cannot_create_branch_office()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('branchOffices.store'), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('branch_offices');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('branchOffices.store'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseEmpty('branch_offices');
    }
}
