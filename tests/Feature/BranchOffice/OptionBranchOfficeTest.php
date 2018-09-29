<?php

namespace Tests\Feature\BranchOffice;

use Tests\TestCase;
use App\{User, BranchOffice};
use Illuminate\Foundation\Testing\RefreshDatabase;

class OptionBranchOfficeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admin_can_update_branch_office_options()
    {
        $admin = $this->createAdmin();
        $branchOffice = factory(BranchOffice::class)->create();

        $response = $this->actingAs($admin)->post("{$branchOffice->slug}/settings", [
            'phone' => '(809) 999-7643',
            'address' => 'Concepcion la vega, Rep. Dominicana',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('branch_offices', [
            'id' => $branchOffice->id,
            'settings' => "{\"phone\":\"(809) 999-7643\",\"address\":\"Concepcion la vega, Rep. Dominicana\"}",
        ]);
    }

    /** @test */
    function settings_are_required()
    {
        $admin = $this->createAdmin();
        $branchOffice = factory(BranchOffice::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($admin)->post("{$branchOffice->slug}/settings", []);

        $response->assertSessionHasErrors(['phone', 'address']);
    }

    /** @test */
    function settings_must_be_and_array()
    {
        $admin = $this->createAdmin();
        $branchOffice = factory(BranchOffice::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($admin)->post("{$branchOffice->slug}/settings", []);

        $response->assertSessionHasErrors(['phone', 'address']);
    }

    /** @test */
    function unauthorized_user_can_not_access_the_options()
    {
        $user = factory(User::class)->create();
        $branchOffice = factory(BranchOffice::class)->create();
        $user->branchOffices()->attach($branchOffice);

        $response = $this->withExceptionHandling()->actingAs($user)->post("{$branchOffice->slug}/settings", [
            'phone' => '(809) 999-7643',
            'address' => 'Concepcion la vega, Rep. Dominicana',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('branch_offices', [
            'settings' => "{\"phone\":\"(809) 999-7643\",\"address\":\"Concepcion la vega, Rep. Dominicana\"}",
        ]);
    }
}
