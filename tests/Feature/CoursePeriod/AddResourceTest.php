<?php

namespace Tests\Feature\CoursePeriod;

use Tests\TestCase;
use App\{CoursePeriod, Resource, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddResourceTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    private $user;

    private $coursePeriod;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->coursePeriod = factory(CoursePeriod::class)->create();

    }

    /** @test */
    function admin_can_add_resource_to_course_period()
    {
        $resources = factory(Resource::class)->times(2)->create([
            'branch_office_id' =>  $this->coursePeriod->period->promotion->branchOffice->id
        ]);

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.resources', [
                'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
                'period' => $this->coursePeriod->period,
                'coursePeriod' => $this->coursePeriod
            ]), [
                'resources' => [$resources[0]->id, $resources[1]->id]
            ])->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('course_period_resource', [
           'course_period_id' => $this->coursePeriod->id,
           'resource_id' =>  $resources[0]->id
        ]);

        $this->assertDatabaseHas('course_period_resource', [
            'course_period_id' => $this->coursePeriod->id,
            'resource_id' =>  $resources[1]->id
        ]);
    }

    /** @test */
    function resource_is_removed_if_it_is_not_specified_again_when_a_new_resource_is_added()
    {
        $diplomado = factory(Resource::class)->create([
            'branch_office_id' =>  $this->coursePeriod->period->promotion->branchOffice->id
        ]);

        $graduacion = factory(Resource::class)->create([
            'branch_office_id' =>  $this->coursePeriod->period->promotion->branchOffice->id
        ]);

        $this->coursePeriod->addResources([$diplomado->id]);

        $this->assertDatabaseHas('course_period_resource', [
            'course_period_id' => $this->coursePeriod->id,
            'resource_id' =>  $diplomado->id
        ]);

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.resources', [
                'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
                'period' => $this->coursePeriod->period,
                'coursePeriod' => $this->coursePeriod
            ]), [
                'resources' => [$graduacion->id]
            ])->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('course_period_resource', [
            'course_period_id' => $this->coursePeriod->id,
            'resource_id' =>  $diplomado->id
        ]);

        $this->assertDatabaseHas('course_period_resource', [
            'course_period_id' => $this->coursePeriod->id,
            'resource_id' =>  $graduacion->id
        ]);
    }

    /** @test */
    function it_only_send_the_id_of_the_resources()
    {
        $this->withExceptionHandling();

        $trash = 'enviar basura';
        $array_trash = ['ataque malicioso', true, 1];

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.resources', [
                'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
                'period' => $this->coursePeriod->period,
                'coursePeriod' => $this->coursePeriod
            ]), [
                'resources' => [$trash, $array_trash]
            ])->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseEmpty('course_period_resource');
    }
}
