<?php

namespace Tests\Browser;

use App\Classroom;
use App\Institute;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClassroomBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_see_all_classrooms()
    {
        $classrooms = factory(Classroom::class)->times(2)->create();
        $this->browse(function (Browser $browser) use($classrooms){
            $browser->loginAs($this->createAdmin())
                ->visit('classrooms')
                ->assertSee($classrooms[0]->name)
                ->assertSee($classrooms[1]->name);
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_create_classroom()
    {
        $institute = factory(Institute::class)->create();

        $this->browse(function (Browser $browser) use($institute){
            $browser->loginAs($this->createAdmin())
                ->visit('classrooms/create')
                ->select('institute_id', $institute->id)
                ->type('name', '301')
                ->type('building', 'Edificio A')
                ->press('Crear')
                ->pause(100);
        });

        $this->assertDatabaseHas('classrooms', [
            'institute_id' => $institute->id,
            'name' => '301',
            'building' => 'Edificio A'
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_update_classrooms()
    {
        $classroom = factory(Classroom::class)->create();
        $this->browse(function (Browser $browser) use($classroom) {
            $browser->loginAs($this->createAdmin())
                ->visit("classrooms/{$classroom->id}/edit")
                ->type('name', '301')
                ->type('building', 'Edificio A')
                ->press('Actualizar')
                ->pause(100);
        });

        $this->assertDatabaseHas('classrooms', [
            'institute_id' => $classroom->institute_id,
            'name' => '301',
            'building' => 'Edificio A'
        ]);
    }
}
