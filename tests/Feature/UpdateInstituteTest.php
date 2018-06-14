<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Institute};
use Silber\Bouncer\BouncerFacade as Bouncer;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInstituteTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Itevo La Vega',
    ];

    private $institute;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->institute = factory(Institute::class)->create();
        Bouncer::scope()->to($this->institute->id)->onlyRelations()->dontScopeRoleAbilities();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_update_institute()
    {
        $this->actingAs($this->admin)
            ->put(route('institutes.update', $this->institute), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Instituto {$this->defaultData['name']} actualizado con exito."]);

        $this->assertDatabaseHas('institutes', $this->withData([
            'id' => $this->institute->id
        ]));
    }

    /** @test */
    function an_guest_cannot_update_institute()
    {
        $this->withExceptionHandling();

        $this->put(route('institutes.update', $this->institute), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('institutes', $this->withData( ));
    }

    /** @test */
    function an_unauthorized_user_cannot_update_institute()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('institutes.update', $this->institute), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('institutes', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put(route('institutes.update', $this->institute), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('institutes', $this->withData());
    }
}
