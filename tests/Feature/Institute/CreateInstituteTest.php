<?php

namespace Tests\Feature\Institute;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInstituteTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Itevo La Vega',
    ];

    /** @test */
    function an_admin_can_create_institute()
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('institutes.store'), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Instituto {$this->defaultData['name']} creado con exito."]);

        $this->assertDatabaseHas('institutes', $this->withData());
    }

    /** @test */
    function an_guest_cannot_create_institute()
    {
        $this->withExceptionHandling();

        $this->post(route('institutes.store'), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('institutes', $this->withData( ));
    }

    /** @test */
    function an_unauthorized_user_cannot_create_institute()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('institutes.store'), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('institutes');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->handleValidationExceptions();

        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('institutes.store'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseEmpty('institutes');
    }
}
