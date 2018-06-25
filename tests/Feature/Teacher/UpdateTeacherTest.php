<?php

namespace Tests\Feature\Teacher;

use Tests\TestCase;
use App\{Promotion, Teacher, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTeacherTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Cristian',
        'last_name' => 'Gomez',
        'id_card' => '999-9999999-9',
        'phone' => '809-999-7643'
    ];

    private $admin;

    private $promotion;

    private $user;

    private $teacher;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->promotion = factory(Promotion::class)->create();
        $this->user = factory(User::class)->create();
        $this->teacher = factory(Teacher::class)->create();
    }

    /** @test */
    function an_admins_can_update_teachers()
    {
        $this->actingAs($this->admin)
            ->put(route('tenant.teachers.update', [
                'institute' => $this->promotion->institute,
                'teacher' =>  $this->teacher
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Profesor {$this->defaultData['name']} {$this->defaultData['last_name']} actualizado correctamente."]);

        $this->assertDatabaseHas('teachers', $this->withData());
    }

    /** @test */
    function a_guest_cannot_update_teachers()
    {
        $this->withExceptionHandling();

        $this->put(route('tenant.teachers.update', [
            'institute' => $this->promotion->institute,
            'teacher' =>  $this->teacher
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('teachers', $this->withData());
    }

    /** @test */
    function an_unauthorized_user_cannot_update_teachers()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('tenant.teachers.update', [
                'institute' => $this->promotion->institute,
                'teacher' =>  $this->teacher
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('teachers', $this->withData());
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->put(route('tenant.teachers.update', [
                'institute' => $this->promotion->institute,
                'teacher' =>  $this->teacher
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'last_name', 'id_card', 'phone']);

        $this->assertDatabaseMissing('teachers', $this->withData());
    }

    /** @test */
    function id_card_must_be_unique()
    {
        $this->withExceptionHandling();

        $teacher = factory(Teacher::class)->create();

        $this->actingAs($this->admin)
            ->put(route('tenant.teachers.update', [
                'institute' => $this->promotion->institute,
                'teacher' =>  $this->teacher
            ]), $this->withData([
                'id_card' => $teacher->id_card
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['id_card']);

        $this->assertDatabaseMissing('teachers', $this->withData([
            'id_card' => $teacher->id_card
        ]));
    }

    /** @test */
    function phone_must_be_unique()
    {
        $this->withExceptionHandling();

        $teacher = factory(Teacher::class)->create();

        $this->actingAs($this->admin)
            ->put(route('tenant.teachers.update', [
                'institute' => $this->promotion->institute,
                'teacher' =>  $this->teacher
            ]), $this->withData([
                'phone' => $teacher->phone
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['phone']);

        $this->assertDatabaseMissing('teachers', $this->withData([
            'phone' => $teacher->phone
        ]));
    }
}
