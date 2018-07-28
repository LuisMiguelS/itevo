<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Ability;
use App\{Promotion, Resource, Student, Teacher, User, Course, TypeCourse, Classroom, BranchOffice};
use Silber\Bouncer\Database\Role;

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
        $this->allAbility();
        $this->dashboardAbility();
        $this->classroomAbilities();
        $this->courseAbilities();
        $this->typeCourseAbilities();
        $this->resourceAbilities();
        $this->teacherAbilities();
        $this->promotionAbility();
        $this->userAbilities();
        $this->roleAbilities();
        $this->studentAbilities();
    }

    protected function createRole()
    {
        /*
        |--------------------------------------------------------------------------
        | Rol de administrador
        |--------------------------------------------------------------------------
        */

        $admin = Bouncer::role()->create([
            'name' => User::ROLE_ADMIN,
            'title' => 'Administrador',
        ]);

        Bouncer::allow($admin)->everything();

        /*
        |--------------------------------------------------------------------------
        | Rol Administrador de instituto
        |--------------------------------------------------------------------------
        */

        $tenant_admin = Bouncer::role()->create([
            'name' => User::ROLE_TENANT_ADMIN,
            'title' => 'Administrador de instituto',
        ]);

        $abilities = Ability::where('name', '<>', '*')->get();
        Bouncer::allow($tenant_admin)->to($abilities);
    }

    protected function allAbility(): void
    {
        /*
         |--------------------------------------------------------------------------
         | Todas las habilidades
         |--------------------------------------------------------------------------
         |
         | Estas habilidades solo las puede tener un rol de administrador, ya que tienen autorizacion total sobre
         | los distintos modulos del sistema.
         */

        Bouncer::ability()->create([
            'name' => '*',
            'title' => 'Todas las habilidades',
            'entity_type' => '*',
        ]);
    }

    protected function dashboardAbility(): void
    {
        /*
         |--------------------------------------------------------------------------
         | Institutos dashboard Habilidades
         |--------------------------------------------------------------------------
         |
         | Habilidad para ver el dashboard de la pagina de administracion
         */
        Bouncer::ability()->createForModel(BranchOffice::class, [
            'name' => 'tenant-view',
            'title' => 'Ver dashboard'
        ]);
    }

    protected function classroomAbilities(): void
    {
        /*
         |--------------------------------------------------------------------------
         | Aulas Habilidades
         |--------------------------------------------------------------------------
         |
         | Todas la habilidades para la gestion del crud de aulas
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
    }

    protected function courseAbilities(): void
    {
        /*
         |--------------------------------------------------------------------------
         | Cursos Habilidades
         |--------------------------------------------------------------------------
         |
         | Todas la habilidades para la gestion del crud de cursos
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
    }

    protected function typeCourseAbilities(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Tipo de cursos Habilidades
        |--------------------------------------------------------------------------
        |
        | Todas la habilidades para la gestion del crud de tipos de cursos
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
    }

    protected function resourceAbilities(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Recursos Habilidades
        |--------------------------------------------------------------------------
        |
        | Todas la habilidades para la gestion del crud de recursos
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
    }

    protected function teacherAbilities(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Profesores Habilidades
        |--------------------------------------------------------------------------
        |
        | Todas la habilidades para la gestion del crud de profesores
        */

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-view',
            'title' => 'Ver profesores'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-create',
            'title' => 'Crear profesor'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar profesor'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar profesor'
        ]);
    }

    protected function promotionAbility(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Promociones Habilidades
        |--------------------------------------------------------------------------
        |
        | Todas la habilidades para la gestion del crud de promociones
        */

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-view',
            'title' => 'Ver promociones'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-create',
            'title' => 'Crear promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-change-status',
            'title' => 'Cambiar estado de las promociones'
        ]);
    }

    protected function userAbilities(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Usuarios Habilidades
        |--------------------------------------------------------------------------
        |
        | Todas la habilidades para la gestion del crud de usuarios
        */

        Bouncer::ability()->createForModel(User::class, [
            'name' => 'view',
            'title' => 'Ver usuarios'
        ]);

        Bouncer::ability()->createForModel(User::class, [
            'name' => 'create',
            'title' => 'Crear usuario'
        ]);

        Bouncer::ability()->createForModel(User::class, [
            'name' => 'delete',
            'title' => 'Eliminar usuario'
        ]);

        Bouncer::ability()->createForModel(User::class, [
            'name' => 'update',
            'title' => 'Actualizar usuario'
        ]);
    }

    protected function roleAbilities(): void
    {
        /*
       |--------------------------------------------------------------------------
       | Roles Habilidades
       |--------------------------------------------------------------------------
       |
       | Todas la habilidades para la gestion del crud de roles
       */

        Bouncer::ability()->createForModel(Role::class, [
            'name' => 'view',
            'title' => 'Ver roles'
        ]);

        Bouncer::ability()->createForModel(Role::class, [
            'name' => 'create',
            'title' => 'Crear rol'
        ]);

        Bouncer::ability()->createForModel(Role::class, [
            'name' => 'delete',
            'title' => 'Eliminar rol'
        ]);

        Bouncer::ability()->createForModel(Role::class, [
            'name' => 'update',
            'title' => 'Actualizar rol'
        ]);
    }

    protected function studentAbilities(): void
    {
        /*
       |--------------------------------------------------------------------------
       | Students Habilidades
       |--------------------------------------------------------------------------
       |
       | Todas la habilidades para la gestion del crud de estudiantes
       */

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'view',
            'title' => 'Ver Estudiantes'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'create',
            'title' => 'Crear Estudiante'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'delete',
            'title' => 'Eliminar Estudiante'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'update',
            'title' => 'Actualizar Estudiante'
        ]);
    }
}
