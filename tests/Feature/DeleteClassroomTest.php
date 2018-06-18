<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Classroom};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteClassroomTestTest extends TestCase
{
    use RefreshDatabase;

    private $classroom;

    private $user;

    private $admin;

    protected function setUp()
    {
        parent::setUp();
        $this->classroom = factory(Classroom::class)->create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    function an_admin_can_delete_classroom()
    {
        $this->actingAs($this->admin)
            ->delete(route('classrooms.destroy', $this->classroom))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Aula {$this->classroom->name} eliminada con éxito."]);

        $this->assertSoftDeleted('classrooms', [
            'id' => $this->classroom->id,
            'name' => $this->classroom->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_classroom()
    {
        $this->withExceptionHandling();

        $this->delete(route('classrooms.destroy', $this->classroom))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('classrooms', [
            'id' => $this->classroom->id,
            'name' => $this->classroom->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_classroom()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('classrooms.destroy', $this->classroom))
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('classrooms', [
            'id' => $this->classroom->id,
            'name' => $this->classroom->name,
        ]);
    }
}
