<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'cristian gomez',
        'email' => 'cristiangomeze@hotmail.com'
    ];

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_update_users()
    {
        $this->actingAs($this->admin)
            ->put(route('users.update', $this->user), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Usuario Cristian Gomez actualizado con exito."]);

        $this->assertDatabaseHas('users', $this->withData());
    }

    /** @test */
    function an_guest_cannot_update_users()
    {
        $this->withExceptionHandling();

        $this->put(route('users.update', $this->user), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('users', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_institute()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('users.update', $this->user), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('users', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put(route('users.update', $this->user), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'email']);

        $this->assertDatabaseMissing('users', $this->withData());
    }

    /** @test */
    function email_must_be_unique()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->actingAs($this->admin)
            ->put(route('users.update', $this->user), $this->withData([
                'email' => $user->email
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', $this->withData());
    }
}
