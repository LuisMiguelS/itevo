<?php

namespace Tests\Feature\Classroom;

use Tests\TestCase;
use App\{
    BranchOffice, User, Classroom
};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteClassroomTest extends TestCase
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
            ->delete($this->classroom->url->delete)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Aula {$this->classroom->name} eliminada con éxito."]);

        $this->assertSoftDeleted('classrooms', [
            'id' => $this->classroom->id,
            'name' => $this->classroom->name,
        ]);
    }

    /** @test */
    function an_admin_cannot_delete_classroom_from_another_brach_office()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->delete(route('tenant.classrooms.destroy', [
                'institute' => factory(BranchOffice::class)->create(),
                'classrooms' => $this->classroom
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseHas('classrooms', [
            'id' => $this->classroom->id,
            'name' => $this->classroom->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_classroom()
    {
        $this->withExceptionHandling();

        $this->delete($this->classroom->url->delete)
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
            ->delete($this->classroom->url->delete)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('classrooms', [
            'id' => $this->classroom->id,
            'name' => $this->classroom->name,
        ]);
    }
}
