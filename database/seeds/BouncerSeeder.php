<?php

use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow(\App\User::ROLE_ADMIN)->everything();

        /*
         * Institute permission
         */
        Bouncer::allow(\App\User::ROLE_TENANT_ADMIN)->to('tenant-view', \App\Institute::class);

        /*
         * Classroom permission
         */
        Bouncer::allow(\App\User::ROLE_TENANT_ADMIN)->to('tenant-view', \App\Classroom::class);
        Bouncer::allow(\App\User::ROLE_TENANT_ADMIN)->to('tenant-create', \App\Classroom::class);
        Bouncer::allow(\App\User::ROLE_TENANT_ADMIN)->to('tenant-update', \App\Classroom::class);
        Bouncer::allow(\App\User::ROLE_TENANT_ADMIN)->to('tenant-delete', \App\Classroom::class);
    }
}
