<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Ability;
use App\{User, Course, TypeCourse, Classroom, Institute};

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAbilities();
        $this->createRole();
    }

    protected function createAbilities()
    {
        /*
         * Todas las habilidades
         */
        Bouncer::ability()->create([
            'name' => '*',
            'title' => 'Todas las habilidades',
            'entity_type' => '*',
        ]);

        /*
         * Classroom Habilidades
         */
        Bouncer::ability()->createForModel(Classroom::class, [
           'name' => 'tenant-view',
           'title' => 'Ver aulas'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-create',
            'title' => 'Crear aulas'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar aulas'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar aulas'
        ]);

        /*
         * Course Habilidades
         */
        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-view',
            'title' => 'Ver cursos'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-create',
            'title' => 'Crear cursos'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar cursos'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar cursos'
        ]);

        /*
        * Tipo de cursos Habilidades
       */
        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-view',
            'title' => 'Ver tipo cursos'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-create',
            'title' => 'Crear tipo cursos'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar tipo cursos'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar tipo cursos'
        ]);

        /*
         * Institute Habilidades
         */
        Bouncer::ability()->createForModel(Institute::class, [
            'name' => 'tenant-view',
            'title' => 'Ver dashboard'
        ]);
    }

    protected function createRole()
    {
        /*
         *  Rol Administrador
         */
        $admin = Bouncer::role()->create([
            'name' => User::ROLE_ADMIN,
            'title' => 'Administrador',
        ]);

        Bouncer::allow($admin)->everything();

        /*
         * Rol Administrador de instituto
         */
        $tenant_admin = Bouncer::role()->create([
            'name' => User::ROLE_TENANT_ADMIN,
            'title' => 'Administrador de instituto',
        ]);

        $abilities = Ability::where('name', '<>', '*')->get();
        Bouncer::allow($tenant_admin)->to($abilities);
    }
}
