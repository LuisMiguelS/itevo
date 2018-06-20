<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\{Course, TypeCourse};
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CourseBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_see_all_course()
    {
        $courses = factory(Course::class)->times(2)->create();
        $this->browse(function (Browser $browser) use($courses){
            $browser->loginAs($this->createAdmin())
                ->visit('courses')
                ->assertSee($courses[0]->name)
                ->assertSee($courses[1]->name);
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_create_course()
    {
        $typeCourse = factory(TypeCourse::class)->create();

        $this->browse(function (Browser $browser) use($typeCourse){
            $browser->loginAs($this->createAdmin())
                ->visit('courses/create')
                ->type('name', 'Informatica')
                ->select('type_course_id', $typeCourse->id)
                ->press('Crear')
                ->pause(100);
        });

        $this->assertDatabaseHas('courses', [
            'id' => 1,
            'name' => 'Informatica',
            'type_course_id' => $typeCourse->id
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_update_course()
    {
        $typeCourse = factory(TypeCourse::class)->create();
        $course = factory(Course::class)->create();

        $this->browse(function (Browser $browser) use($typeCourse, $course) {
            $browser->loginAs($this->createAdmin())
                ->visit("courses/{$course->id}/edit")
                ->type('name', 'Informatica')
                ->select('type_course_id', $typeCourse->id)
                ->press('Actualizar')
                ->pause(100);
        });

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Informatica',
            'type_course_id' => $typeCourse->id
        ]);
    }
}
