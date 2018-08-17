<?php

namespace Tests\Feature\CoursePeriod;

use Carbon\Carbon;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\{Classroom, Course, CoursePeriod, Period, Teacher, User};

class UpdateCoursePeriodTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'price' => 400.11,
    ];

    private $admin;

    private $user;

    private $period;

    private $classroom;

    private $teacher;

    private $coursePeriod;

    private $course;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->period = factory(Period::class)->create();
        $this->course = factory(Course::class)->create();
        $this->classroom = factory(Classroom::class)->create();
        $this->teacher = factory(Teacher::class)->create();
        $this->coursePeriod = factory(CoursePeriod::class)->create();
    }

    /** @test */
    function an_admin_can_update_course_period()
    {
        $this->actingAs($this->admin)
            ->put(route('tenant.periods.course-period.update', [
                'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
                'period' => $this->coursePeriod->period,
                'coursePeriod' => $this->coursePeriod
            ]), $this->withData([
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_at' => Carbon::now()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth()->toDateTimeString()
            ]))->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Curso activado actualizado correctamente."]);

        $this->assertDatabaseHas('course_period', $this->withData([
            'period_id' => $this->coursePeriod->period->id,
            'teacher_id' => $this->teacher->id,
            'classroom_id' => $this->classroom->id,
            'course_id' => $this->course->id,
            'start_at' => Carbon::now()->toDateTimeString(),
            'ends_at' => Carbon::now()->addMonth()->toDateTimeString()
        ]));
    }

    /** @test */
    function an_guest_cannot_update_course_period()
    {
        $this->withExceptionHandling();

        $this->put(route('tenant.periods.course-period.update', [
            'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
            'period' => $this->coursePeriod->period,
            'coursePeriod' => $this->coursePeriod
        ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function an_unauthorized_user_cannot_update_course_period()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('tenant.periods.course-period.update', [
                'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
                'period' => $this->coursePeriod->period,
                'coursePeriod' => $this->coursePeriod
            ]), $this->withData([
                'period_id' => $this->period->promotion->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_at' => Carbon::now()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth()->toDateTimeString()
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function it_can_see_validations_errors_in_form_course_period()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->put(route('tenant.periods.course-period.update', [
                'branchOffice' => $this->coursePeriod->period->promotion->branchOffice,
                'period' => $this->coursePeriod->period,
                'coursePeriod' => $this->coursePeriod
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors([
                'price',
                'teacher_id',
                'classroom_id',
                'course_id',
                'start_at',
                'ends_at'
            ]);
    }

    /** @test */
    function it_cannot_update_course_period_if_current_promoton_not_have_current_period()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create(['status' => Period::STATUS_WITHOUT_STARTING]);

        $coursePeriod = factory(CoursePeriod::class)->create([
            'period_id' => $period->id
        ]);

        $this->actingAs($this->admin)
            ->put(route('tenant.periods.course-period.update', [
                'branchOffice' => $coursePeriod->period->promotion->branchOffice,
                'period' => $coursePeriod->period,
                'coursePeriod' => $coursePeriod
            ]), $this->withData([
                'period_id' => $period->promotion->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_at' => Carbon::now()->subDay()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth()->toDateTimeString()

            ]))->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    function it_cannot_update_course_period_if_start_at_is_less_than_period_start_at()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create([
            'start_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addMonth(4),
        ]);

        $coursePeriod = factory(CoursePeriod::class)->create([
            'period_id' => $period->id
        ]);

        $this->actingAs($this->admin)
            ->put(route('tenant.periods.course-period.update', [
                'branchOffice' => $coursePeriod->period->promotion->branchOffice,
                'period' => $coursePeriod->period,
                'coursePeriod' => $coursePeriod
            ]), $this->withData([
                'period_id' => $period->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_at' => Carbon::now()->subDay()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth()->toDateTimeString()

            ]))->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    function it_cannot_update_course_period_if_ends_at_is_higher_than_period_ends_at()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create([
            'start_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addMonth(4),
        ]);

        $coursePeriod = factory(CoursePeriod::class)->create([
            'period_id' => $period->id
        ]);

        $this->actingAs($this->admin)
            ->put(route('tenant.periods.course-period.update', [
                'branchOffice' => $coursePeriod->period->promotion->branchOffice,
                'period' => $coursePeriod->period,
                'coursePeriod' => $coursePeriod
            ]), $this->withData([
                'period_id' => $period->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_at' => Carbon::now()->subDay()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth(5)->toDateTimeString()
            ]))->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
