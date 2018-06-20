<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_see_all_user()
    {
        $users = factory(User::class)->times(2)->create();

        $this->browse(function (Browser $browser) use($users){
            $browser->loginAs($this->createAdmin())
                ->visit('users')
                ->assertSee($users[0]->name)
                ->assertSee($users[1]->name);
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_create_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->createAdmin())
                ->visit('users/create')
                ->type('name', 'Cristian Gomez')
                ->type('email', 'cristiangomeze@hotmail.com')
                ->type('password', '123456')
                ->type('password_confirmation', '123456')
                ->press('Crear')
                ->pause(100);
        });

        $this->assertCredentials([
            'email' => 'cristiangomeze@hotmail.com',
            'password' => '123456'
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    function admin_can_update_user()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($this->createAdmin())
                ->visit("users/{$user->id}/edit")
                ->type('name', 'Cristian Gomez')
                ->type('email', 'cristiangomeze@hotmail.com')
                ->press('Actualizar')
                ->pause(100);
        });

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Cristian Gomez',
            'email' => 'cristiangomeze@hotmail.com',
        ]);
    }
}
