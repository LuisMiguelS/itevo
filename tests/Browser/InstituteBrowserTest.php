<?php

namespace Tests\Browser;

use App\Institute;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InstituteBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_see_all_institutes()
    {
        $institutes = factory(Institute::class)->times(2)->create();
        $this->browse(function (Browser $browser) use($institutes){
            $browser->loginAs($this->createAdmin())
                ->visit('institutes')
                ->assertSee($institutes[0]->name)
                ->assertSee($institutes[1]->name);
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_create_institute()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->createAdmin())
                ->visit('institutes/create')
                ->type('name', 'Itevo La Vega')
                ->press('Crear')
                ->pause(100);
        });

        $this->assertDatabaseHas('institutes', [
            'name' => 'Itevo La Vega'
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_update_institute()
    {
        $institute = factory(Institute::class)->create();
        $this->browse(function (Browser $browser) use($institute) {
            $browser->loginAs($this->createAdmin())
                ->visit("institutes/{$institute->slug}/edit")
                ->type('name', 'Itevo La Vega')
                ->press('Actualizar')
                ->pause(100);
        });

        $this->assertDatabaseHas('institutes', [
            'name' => 'Itevo La Vega'
        ]);
    }
}
