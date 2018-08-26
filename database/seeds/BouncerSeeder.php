<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;
use App\{CoursePeriod,
    Period,
    Promotion,
    Resource,
    Schedule,
    Student,
    Teacher,
    User,
    Course,
    TypeCourse,
    Classroom,
    BranchOffice};

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
        $this->periodAbilities();
        $this->coursePeriodAbilities();
        $this->scheduleAbilities();
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


    /*
    |--------------------------------------------------------------------------
    | Todas las habilidades
    |--------------------------------------------------------------------------
    |
    | Estas habilidades solo las puede tener un rol de administrador, ya que tienen autorizacion total sobre
    | los distintos modulos del sistema.
    */

    protected function allAbility(): void
    {
        Bouncer::ability()->create([
            'name' => '*',
            'title' => 'Todas las habilidades',
            'entity_type' => '*',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Institutos dashboard Habilidades
    |--------------------------------------------------------------------------
    |
    | Habilidad para ver el dashboard de la pagina de administracion
    */

    protected function dashboardAbility(): void
    {
        Bouncer::ability()->createForModel(BranchOffice::class, [
            'name' => 'tenant-view',
            'title' => 'Ver dashboard'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Aulas Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de aulas
    */

    protected function classroomAbilities(): void
    {
        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-view',
            'title' => 'Ver aulas'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-create',
            'title' => 'Crear aula'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar aula'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente una aula'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal una aula'
        ]);

        Bouncer::ability()->createForModel(Classroom::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar aula'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cursos Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de cursos
    */

    protected function courseAbilities(): void
    {
        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-view',
            'title' => 'Ver cursos'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-create',
            'title' => 'Crear curso'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar curso'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente un curso'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal un curso'
        ]);

        Bouncer::ability()->createForModel(Course::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar curso'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Tipo de cursos Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de tipos de cursos
    */
    protected function typeCourseAbilities(): void
    {
        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-view',
            'title' => 'Ver tipos cursos'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-create',
            'title' => 'Crear tipo curso'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar tipo curso'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente un tipo de curso'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal un tipo de curso'
        ]);

        Bouncer::ability()->createForModel(TypeCourse::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar tipo de curso'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Recursos Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de recursos
    */

    protected function resourceAbilities(): void
    {
        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-view',
            'title' => 'Ver recursos'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-create',
            'title' => 'Crear recurso'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar recurso'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente un recurso'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal un recurso'
        ]);

        Bouncer::ability()->createForModel(Resource::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar recurso'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Profesores Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de profesores
    */

    protected function teacherAbilities(): void
    {
        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-view',
            'title' => 'Ver profesores'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-create',
            'title' => 'Crear profesor'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar profesor'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente un profesor'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal un profesor'
        ]);

        Bouncer::ability()->createForModel(Teacher::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar profesor'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Promociones Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de promociones
    */

    protected function promotionAbility(): void
    {
        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-view',
            'title' => 'Ver promociones'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-create',
            'title' => 'Crear promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente una promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal una promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar promocion'
        ]);

        Bouncer::ability()->createForModel(Promotion::class, [
            'name' => 'tenant-finish',
            'title' => 'Finalizar promocion'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Usuarios Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de usuarios
    */

    protected function userAbilities(): void
    {
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

    /*
    |--------------------------------------------------------------------------
    | Roles Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de roles
    */

    protected function roleAbilities(): void
    {
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

    /*
    |--------------------------------------------------------------------------
    | Students Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de estudiantes
    */

    protected function studentAbilities(): void
    {
        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'tenant-view',
            'title' => 'Ver Estudiantes'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'tenant-create',
            'title' => 'Crear Estudiante'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar Estudiante'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente un estudiante'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal un estudiante'
        ]);

        Bouncer::ability()->createForModel(Student::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar estudiante'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Period Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de periodos
    */

    protected function periodAbilities(): void
    {
        Bouncer::ability()->createForModel(Period::class, [
            'name' => 'tenant-view',
            'title' => 'Ver Periodos'
        ]);

        Bouncer::ability()->createForModel(Period::class, [
            'name' => 'tenant-create',
            'title' => 'Crear Periodo'
        ]);

        Bouncer::ability()->createForModel(Period::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar Periodo'
        ]);

        Bouncer::ability()->createForModel(Period::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar Periodo'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Period Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de asignacion de cursos
    */

    protected function coursePeriodAbilities(): void
    {
        Bouncer::ability()->createForModel(CoursePeriod::class, [
            'name' => 'tenant-view',
            'title' => 'Ver cursos activos'
        ]);

        Bouncer::ability()->createForModel(CoursePeriod::class, [
            'name' => 'tenant-create',
            'title' => 'Asignar curso a promocion'
        ]);

        Bouncer::ability()->createForModel(CoursePeriod::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar curso asignado a la promocion'
        ]);

        Bouncer::ability()->createForModel(CoursePeriod::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar curso asignado a la promocion'
        ]);

        Bouncer::ability()->createForModel(CoursePeriod::class, [
            'name' => 'tenant-addResource',
            'title' => 'Vincular recurso con curso activo'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Schedule Habilidades
    |--------------------------------------------------------------------------
    |
    | Todas la habilidades para la gestion del crud de horarios
    */
    protected function scheduleAbilities()
    {
        Bouncer::ability()->createForModel(Schedule::class, [
            'name' => 'tenant-view',
            'title' => 'Ver horarios'
        ]);

        Bouncer::ability()->createForModel(Schedule::class, [
            'name' => 'tenant-create',
            'title' => 'Crear horario'
        ]);

        Bouncer::ability()->createForModel(Schedule::class, [
            'name' => 'tenant-update',
            'title' => 'Actualizar horario'
        ]);

        Bouncer::ability()->createForModel(Schedule::class, [
            'name' => 'tenant-delete',
            'title' => 'Eliminar permanentemente un horario'
        ]);

        Bouncer::ability()->createForModel(Schedule::class, [
            'name' => 'tenant-trash',
            'title' => 'Eliminar temporal un horario'
        ]);

        Bouncer::ability()->createForModel(Schedule::class, [
            'name' => 'tenant-restore',
            'title' => 'Restaurar horario'
        ]);
    }
}
