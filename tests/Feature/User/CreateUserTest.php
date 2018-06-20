<?php

namespace Tests\Feature\User;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Cristian Gomez',
        'email' => 'cristiangomeze@hotmail.com',
        'password' => 'secret'
    ];

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_create_users()
    {
        $this->actingAs($this->admin)
            ->post(route('users.store'), $this->withData([
                'password_confirmation' => $this->defaultData['password']
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Usuario {$this->defaultData['name']} creado con éxito."]);

        $this->assertCredentials($this->withData());
    }

    /** @test */
    function an_guest_cannot_create_users()
    {
        $this->withExceptionHandling();

        $this->post(route('users.store'), $this->withData([
            'password_confirmation' => $this->defaultData['password']
        ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('users', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_create_users()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('users.store'), $this->withData([
                'password_confirmation' => $this->defaultData['password']
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('users', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('users.store'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'email', 'password']);

        $this->assertDatabaseMissing('users', $this->withData());
    }

    /** @test */
    function email_must_be_unique()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->actingAs($this->admin)
            ->post(route('users.store'), $this->withData([
                'email' => $user->email
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', $this->withData());
    }
}
