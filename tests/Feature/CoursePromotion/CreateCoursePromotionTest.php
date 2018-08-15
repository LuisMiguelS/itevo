<?php

namespace Tests\Feature\CoursePromotion;

use Carbon\Carbon;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\{Classroom, Course, Promotion, Teacher, User};

class CreateCoursePromotionTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'price' => 400.10,
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
     * @var \App\Promotion
     */
    private $promotion;

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
        $this->promotion = factory(Promotion::class)->create();
        $this->course = factory(Course::class)->create();
        $this->classroom = factory(Classroom::class)->create();
        $this->teacher = factory(Teacher::class)->create();
    }

    /** @test */
    function an_admin_can_create_course_promotion()
    {
        $this->actingAs($this->admin)
            ->post(route('tenant.promotions.courses.store', [
                'branchOffice' => $this->promotion->branchOffice,
                'promotion' => $this->promotion
            ]), $this->withData([
                'promotion_id' => $this->promotion->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_time' => Carbon::now()->toDateTimeString(),
                'output_time' => Carbon::now()->addHour(4)->toDateTimeString(),
                'start_date_at' => Carbon::now()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth()->toDateTimeString()

            ]))->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Curso activado correctamente."]);

        $this->assertDatabaseHas('course_promotion', $this->withData([
            'promotion_id' => $this->promotion->id,
            'teacher_id' => $this->teacher->id,
            'classroom_id' => $this->classroom->id,
            'course_id' => $this->course->id,
            'start_time' => Carbon::now()->toDateTimeString(),
            'output_time' => Carbon::now()->addHour(4)->toDateTimeString(),
            'start_date_at' => Carbon::now()->toDateTimeString(),
            'ends_at' => Carbon::now()->addMonth()->toDateTimeString()
        ]));
    }

    /** @test */
    function an_guest_cannot_create_course_promotion()
    {
        $this->withExceptionHandling();

        $this->post(route('tenant.promotions.courses.store', [
            'branchOffice' => $this->promotion->branchOffice,
            'promotion' => $this->promotion
        ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseEmpty('course_promotion');
    }

    /** @test */
    function an_unauthorized_user_cannot_create_course_promotion()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('tenant.promotions.courses.store', [
                'branchOffice' => $this->promotion->branchOffice,
                'promotion' => $this->promotion
            ]), $this->withData([
                'promotion_id' => $this->promotion->id,
                'teacher_id' => $this->teacher->id,
                'classroom_id' => $this->classroom->id,
                'course_id' => $this->course->id,
                'start_time' => Carbon::now()->toDateTimeString(),
                'output_time' => Carbon::now()->addHour(4)->toDateTimeString(),
                'start_date_at' => Carbon::now()->toDateTimeString(),
                'ends_at' => Carbon::now()->addMonth()->toDateTimeString()
            ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseEmpty('course_promotion');
    }

    /** @test */
    function it_can_see_validations_errors_in_form_course_promotion()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->admin)
            ->post(route('tenant.promotions.courses.store', [
                'branchOffice' => $this->promotion->branchOffice,
                'promotion' => $this->promotion
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors([
                'price',
                'teacher_id',
                'classroom_id',
                'course_id',
                'start_time',
                'output_time',
                'start_date_at',
                'ends_at'
            ]);

        $this->assertDatabaseEmpty('course_promotion');
    }
}
