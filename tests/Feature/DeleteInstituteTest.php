<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Institute};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteInstituteTest extends TestCase
{
    use RefreshDatabase;

    private $institute;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->institute = factory(Institute::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_delete_institute()
    {
        $this->actingAs($this->admin)
            ->delete(route('institutes.destroy', $this->institute))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Instituto {$this->institute->name} eliminado con exito."]);

        $this->assertSoftDeleted('institutes', [
            'id' => $this->institute->id,
            'name' => $this->institute->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_institute()
    {
        $this->withExceptionHandling();

        $this->delete(route('institutes.destroy', $this->institute))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('institutes', [
            'id' => $this->institute->id,
            'name' => $this->institute->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_institute()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('institutes.destroy', $this->institute))
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('institutes', [
            'id' => $this->institute->id,
            'name' => $this->institute->name,
        ]);
    }
}
