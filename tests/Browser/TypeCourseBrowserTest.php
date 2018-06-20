<?php

namespace Tests\Browser;

use App\TypeCourse;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TypeCourseBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_see_all_types_courses()
    {
        $typeCourses = factory(TypeCourse::class)->times(2)->create();
        $this->browse(function (Browser $browser) use($typeCourses){
            $browser->loginAs($this->createAdmin())
                ->visit('types/courses')
                ->assertSee($typeCourses[0]->name)
                ->assertSee($typeCourses[1]->name);
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_create_type_course()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->createAdmin())
                ->visit('types/courses/create')
                ->type('name', 'Diplomado')
                ->press('Crear')
                ->pause(100);
        });

        $this->assertDatabaseHas('type_courses', [
            'id' => 1,
            'name' => 'Diplomado',
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_update_type_course()
    {
        $typeCourse = factory(TypeCourse::class)->create();
        $this->browse(function (Browser $browser) use($typeCourse) {
            $browser->loginAs($this->createAdmin())
                ->visit("types/courses/{$typeCourse->id}/edit")
                ->type('name', 'Diplomado')
                ->press('Actualizar')
                ->pause(100);
        });

        $this->assertDatabaseHas('type_courses', [
            'id' => $typeCourse->id,
            'name' => 'Diplomado',
        ]);
    }
}
