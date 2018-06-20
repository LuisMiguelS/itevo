<?php

namespace Tests\Feature\User;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteuserTestTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_delete_user()
    {
        $this->actingAs($this->admin)
            ->delete(route('users.destroy', $this->user))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Usuario {$this->user->name} eliminado con éxito."]);

        $this->assertSoftDeleted('users', [
            'id' => $this->user->id,
            'name' => $this->user->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_user()
    {
        $this->withExceptionHandling();

        $this->delete(route('users.destroy', $this->user))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $this->user->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_user()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('users.destroy', $this->user))
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $this->user->name,
        ]);
    }
}
