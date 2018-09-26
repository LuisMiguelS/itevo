<?php

namespace Tests\Feature\CoursePeriod;

use Carbon\Carbon;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\{Classroom, Course, Period, Teacher, User};

class CreateCoursePeriodTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'price' => 400.10,
        'start_at' => '2018-09-26 02:31:43',
        'ends_at' => '2018-10-26 04:31:43'
    ];

    /**
     * @var \App\User
     */
    private $admin;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Period
     */
    private $period;

    /**
     * @var \App\Course
     */
    private $course;

    /**
     * @var \App\Classroom
     */
    private $classroom;

    /**
     * @var \App\Teacher
     */
    private $teacher;

    protected function setUp()
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
        $this->user = factory(User::class)->create();
        $this->period = factory(Period::class)->create([
            'start_at' => '2018-09-26 00:31:43',
            'ends_at' => '2018-11-26 02:30:00',
        ]);
        $this->course = factory(Course::class)->create();
        $this->classroom = factory(Classroom::class)->create();
        $this->teacher = factory(Teacher::class)->create();
    }

    /** @test */
    function an_admin_can_create_course_period()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.store', [
                'branchOffice' => $this->period->promotion->branchOffice,
                'period' => $this->period
            ]), $this->withData([
                'period_id' => $this->period->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,

            ]))->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Curso activado correctamente."]);

        $this->assertDatabaseHas('course_period', $this->withData([
            'period_id' => $this->period->id,
            'teacher_id' => $this->teacher->id,
            'classroom_id' => $this->classroom->id,
            'course_id' => $this->course->id,
        ]));
    }

    /** @test */
    function an_guest_cannot_create_course_period()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.periods.course-period.store', [
            'branchOffice' => $this->period->promotion->branchOffice,
            'period' => $this->period
        ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseEmpty('course_period');
    }

    /** @test */
    function an_unauthorized_user_cannot_create_course_period()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('tenant.periods.course-period.store', [
                'branchOffice' => $this->period->promotion->branchOffice,
                'period' => $this->period
            ]), $this->withData([
                'period_id' => $this->period->promotion->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('course_period');
    }

    /** @test */
    function it_can_see_validations_errors_in_form_course_period()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.store', [
                'branchOffice' => $this->period->promotion->branchOffice,
                'period' => $this->period
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

        $this->assertDatabaseEmpty('course_period');
    }

    /** @test */
    function it_cannot_create_course_period_if_current_promoton_not_have_current_period()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create(['status' => Period::STATUS_WITHOUT_STARTING]);

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.store', [
                'branchOffice' => $period->promotion->branchOffice,
                'period' => $period
            ]), $this->withData([
                'period_id' => $period->promotion->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,

            ]))->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('course_period');
    }

    /** @test */
    function it_cannot_create_course_period_if_start_at_is_less_than_period_start_at()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create([
            'start_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addMonth(4),
        ]);

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.store', [
                'branchOffice' => $period->promotion->branchOffice,
                'period' => $period
            ]), $this->withData([
                'period_id' => $period->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_at' => Carbon::now()->subDay()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth()->toDateTimeString()

            ]))->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('course_period');
    }

    /** @test */
    function it_cannot_create_course_period_if_ends_at_is_higher_than_period_ends_at()
    {
        $this->withExceptionHandling();

        $period = factory(Period::class)->create([
            'start_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addMonth(4),
        ]);

        $this->actingAs($this->admin)
            ->post(route('tenant.periods.course-period.store', [
                'branchOffice' => $period->promotion->branchOffice,
                'period' => $period
            ]), $this->withData([
                'period_id' => $period->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_at' => Carbon::now()->subDay()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth(5)->toDateTimeString()
            ]))->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseEmpty('course_period');
    }
}
