<?php

use App\{Classroom,
    Course,
    BranchOffice,
    CoursePeriod,
    Period,
    Promotion,
    Resource,
    Schedule,
    Student,
    Teacher,
    TypeCourse};

Breadcrumbs::for('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::for('dashboard', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Dashboard', route('tenant.dashboard', $branchOffice));
});

/*
|--------------------------------------------------------------------------
| Classroom
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('classroom', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Aulas', route('tenant.classrooms.index', $branchOffice));
});

Breadcrumbs::for('classroom-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('classroom', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.classrooms.trash', $branchOffice));
});

Breadcrumbs::for('classroom-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('classroom', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.classrooms.create', $branchOffice));
});

Breadcrumbs::for('classroom-edit', function ($breadcrumbs, BranchOffice $branchOffice, Classroom $classroom) {
    $breadcrumbs->parent('classroom', $branchOffice);
    $breadcrumbs->push($classroom->name, $classroom->url->edit);
});

/*
|--------------------------------------------------------------------------
| Courses
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('course', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Cursos', route('tenant.courses.index', $branchOffice));
});

Breadcrumbs::for('course-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('course', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.courses.trash', $branchOffice));
});

Breadcrumbs::for('course-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('course', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.classrooms.create', $branchOffice));
});

Breadcrumbs::for('course-edit', function ($breadcrumbs, BranchOffice $branchOffice, Course $course) {
    $breadcrumbs->parent('course', $branchOffice);
    $breadcrumbs->push($course->name, $course->url->edit);
});

/*
|--------------------------------------------------------------------------
| Type Courses
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('typeCourse', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Tipos de cursos', route('tenant.typeCourses.index', $branchOffice));
});

Breadcrumbs::for('typeCourse-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('typeCourse', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.typeCourses.trash', $branchOffice));
});

Breadcrumbs::for('typeCourse-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('typeCourse', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.typeCourses.create', $branchOffice));
});

Breadcrumbs::for('typeCourse-edit', function ($breadcrumbs, BranchOffice $branchOffice, TypeCourse $typeCourse) {
    $breadcrumbs->parent('typeCourse', $branchOffice);
    $breadcrumbs->push($typeCourse->name, $typeCourse->url->edit);
});

/*
|--------------------------------------------------------------------------
| Resoruce
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('resource', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Recursos', route('tenant.resources.index', $branchOffice));
});

Breadcrumbs::for('resource-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('resource', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.resources.trash', $branchOffice));
});

Breadcrumbs::for('resource-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('resource', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.resources.create', $branchOffice));
});

Breadcrumbs::for('resource-edit', function ($breadcrumbs, BranchOffice $branchOffice, Resource $resource) {
    $breadcrumbs->parent('resource', $branchOffice);
    $breadcrumbs->push($resource->name, $resource->url->edit);
});

/*
|--------------------------------------------------------------------------
| Teacher
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('teacher', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Profesor', route('tenant.teachers.index', $branchOffice));
});

Breadcrumbs::for('teacher-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('teacher', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.teachers.trash', $branchOffice));
});

Breadcrumbs::for('teacher-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('teacher', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.teachers.create', $branchOffice));
});

Breadcrumbs::for('teacher-edit', function ($breadcrumbs, BranchOffice $branchOffice, Teacher $teacher) {
    $breadcrumbs->parent('teacher', $branchOffice);
    $breadcrumbs->push($teacher->full_name, $teacher->url->edit);
});

/*
|--------------------------------------------------------------------------
| Promotion
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('promotion', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Promociones', route('tenant.promotions.index', $branchOffice));
});

Breadcrumbs::for('promotion-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('promotion', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.promotions.trash', $branchOffice));
});

Breadcrumbs::for('promotion-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('promotion', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.promotions.create', $branchOffice));
});

Breadcrumbs::for('promotion-edit', function ($breadcrumbs, BranchOffice $branchOffice, Promotion $promotion) {
    $breadcrumbs->parent('teacher', $branchOffice);
    $breadcrumbs->push("Promocion {$promotion->promotion_no}", $promotion->url->edit);
});

/*
|--------------------------------------------------------------------------
| Student
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('student', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Estudiantes', route('tenant.students.index', $branchOffice));
});

Breadcrumbs::for('student-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('student', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.students.trash', $branchOffice));
});

Breadcrumbs::for('student-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('student', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.students.create', $branchOffice));
});

Breadcrumbs::for('student-edit', function ($breadcrumbs, BranchOffice $branchOffice, Student $student) {
    $breadcrumbs->parent('student', $branchOffice);
    $breadcrumbs->push($student->full_name, $student->url->edit);
});


/*
|--------------------------------------------------------------------------
| Schedule
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('schedule', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Horarios', route('tenant.schedules.index', $branchOffice));
});

Breadcrumbs::for('schedule-trash', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('schedule', $branchOffice);
    $breadcrumbs->push('Papelera', route('tenant.schedules.trash', $branchOffice));
});

Breadcrumbs::for('schedule-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('schedule', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.schedules.create', $branchOffice));
});

Breadcrumbs::for('schedule-edit', function ($breadcrumbs, BranchOffice $branchOffice, Schedule $schedule) {
    $breadcrumbs->parent('schedule', $branchOffice);
    $breadcrumbs->push("{$schedule->start_at->format('h:i:s A')} - {$schedule->ends_at->format('h:i:s A')}", $schedule->url->edit);
});

/*
|--------------------------------------------------------------------------
| Period
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('period', function ($breadcrumbs, BranchOffice $branchOffice, Promotion $promotion) {
    $breadcrumbs->parent('promotion', $branchOffice);
    $breadcrumbs->push("Periodos de la promocion no. {$promotion->promotion_no}", route('tenant.promotions.periods.index', ['branchOffice' => $branchOffice, 'promotion' => $promotion]));
});

Breadcrumbs::for('period-create', function ($breadcrumbs, BranchOffice $branchOffice, Promotion $promotion) {
    $breadcrumbs->parent('period', $branchOffice, $promotion);
    $breadcrumbs->push("Crear", route('tenant.promotions.periods.create', ['branchOffice' => $branchOffice, 'promotion' => $promotion]));
});

Breadcrumbs::for('period-edit', function ($breadcrumbs, BranchOffice $branchOffice, Promotion $promotion, Period $period) {
    $breadcrumbs->parent('period', $branchOffice, $promotion);
    $breadcrumbs->push("{$period->period_no}", route('tenant.promotions.periods.edit', ['branchOffice' => $branchOffice, 'promotion' => $promotion, 'period' => $period]));
});


/*
|--------------------------------------------------------------------------
| CoursePeriod
|--------------------------------------------------------------------------
*/

Breadcrumbs::for('coursePeriod', function ($breadcrumbs, BranchOffice $branchOffice, Period $period) {
    $breadcrumbs->parent('period', $branchOffice, $period->promotion);
    $breadcrumbs->push("Cursos activos del {$period->period_no}", route('tenant.periods.course-period.index', ['branchOffice' => $branchOffice, 'period' => $period]));
});

Breadcrumbs::for('coursePeriod-create', function ($breadcrumbs, BranchOffice $branchOffice, Period $period) {
    $breadcrumbs->parent('coursePeriod', $branchOffice, $period);
    $breadcrumbs->push("Crear", route('tenant.periods.course-period.create', ['branchOffice' => $branchOffice, 'period' => $period]));
});

Breadcrumbs::for('coursePeriod-edit', function ($breadcrumbs, BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod) {
    $breadcrumbs->parent('coursePeriod', $branchOffice, $period);
    $breadcrumbs->push("{$coursePeriod->course->name} ({$coursePeriod->course->typeCourse->name})", route('tenant.periods.course-period.edit', ['branchOffice' => $branchOffice, 'period' => $period, 'coursePeriod' => $coursePeriod]));
});

Breadcrumbs::for('coursePeriod-resource', function ($breadcrumbs, BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod) {
    $breadcrumbs->parent('coursePeriod', $branchOffice, $period);
    $breadcrumbs->push("Agregar recursos: {$coursePeriod->course->name} ({$coursePeriod->course->typeCourse->name})", route('tenant.periods.course-period.resources.index', ['branchOffice' => $branchOffice, 'period' => $period, 'coursePeriod' => $coursePeriod]));
});

Breadcrumbs::for('coursePeriod-schedule', function ($breadcrumbs, BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod) {
    $breadcrumbs->parent('coursePeriod', $branchOffice, $period);
    $breadcrumbs->push("Agregar horarios: {$coursePeriod->course->name} ({$coursePeriod->course->typeCourse->name})", route('tenant.periods.course-period.schedules.index', ['branchOffice' => $branchOffice, 'period' => $period, 'coursePeriod' => $coursePeriod]));
});