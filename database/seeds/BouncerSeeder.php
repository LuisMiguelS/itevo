<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Ability;
use App\{
    Resource, User, Course, TypeCourse, Classroom, Institute
};

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
            'title' => 'Crear aula'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar aula'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar aula'
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
            'title' => 'Crear curso'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar curso'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar curso'
        ]);

        /*
        * Tipo de cursos Habilidades
       */
        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-view',
            'title' => 'Ver tipos cursos'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-create',
            'title' => 'Crear tipo curso'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar tipo curso'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar tipo curso'
        ]);

        /*
       * Tipo de cursos Habilidades
      */
        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-view',
            'title' => 'Ver recursos'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-create',
            'title' => 'Crear recurso'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar recurso'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar recurso'
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
