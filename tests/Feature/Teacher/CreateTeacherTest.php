<?php

namespace Tests\Feature\Teacher;

use Tests\TestCase;
use App\{Promotion, Teacher, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTeacherTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Cristian',
        'last_name' => 'Gomez',
        'id_card' => '999-9999999-9',
        'phone' => '(809) 999-7643'
    ];

    private $admin;

    private $promotion;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->promotion = factory(Promotion::class)->create();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    function an_admins_can_create_teachers()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.teachers.store', $this->promotion->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Profesor {$this->defaultData['name']} {$this->defaultData['last_name']} creado correctamente."]);

        $this->assertDatabaseHas('teachers', $this->withData());
    }

    /** @test */
    function a_guest_cannot_create_teachers()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.teachers.store', $this->promotion->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseEmpty('teachers');
    }

    /** @test */
    function an_unauthorized_user_cannot_create_teachers()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('tenant.teachers.store', $this->promotion->branchOffice), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('teachers');
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.teachers.store', $this->promotion->branchOffice), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'last_name', 'id_card', 'phone']);

        $this->assertDatabaseEmpty('teachers');
    }

    /** @test */
    function a_teacher_id_card_must_be_unique()
    {
        $this->withExceptionHandling();

        $teacher = factory(Teacher::class)->create();

        $this->actingAs($this->admin)
            ->post(route('tenant.teachers.store', $teacher->branchOffice), $this->withData([
                'id_card' => $teacher->id_card
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['id_card']);

        $this->assertDatabaseMissing('teachers', $this->withData([
            'id_card' => $teacher->id_card
        ]));
    }

    /** @test */
    function a_teacher_phone_must_be_unique()
    {
        $teacher = factory(Teacher::class)->create();

        $this->withExceptionHandling();

        $this->actingAs($this->admin)
            ->post(route('tenant.teachers.store', $teacher->branchOffice), $this->withData([
                'phone' => $teacher->phone
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['phone']);

        $this->assertDatabaseMissing('teachers', $this->withData([
            'phone' => $teacher->phone
        ]));
    }
}
