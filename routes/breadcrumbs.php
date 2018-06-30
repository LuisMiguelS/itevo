<?php

use App\{
    Classroom, Course, Institute, Resource, Teacher, TypeCourse
};

Breadcrumbs::for('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::for('dashboard', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Dashboard', route('tenant.dashboard', $institute));
});

// Classroom
Breadcrumbs::for('classroom', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('dashboard', $institute);
    $breadcrumbs->push('Aulas', route('tenant.classrooms.index', $institute));
});

Breadcrumbs::for('classroom-create', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('classroom', $institute);
    $breadcrumbs->push('Crear', route('tenant.classrooms.create', $institute));
});

Breadcrumbs::for('classroom-edit', function ($breadcrumbs, Institute $institute, Classroom $classroom) {
    $breadcrumbs->parent('classroom', $institute);
    $breadcrumbs->push($classroom->name, route('tenant.classrooms.edit', [
        'institute' => $institute,
        'classroom' => $classroom
    ]));
});

// Courses
Breadcrumbs::for('course', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('dashboard', $institute);
    $breadcrumbs->push('Cursos', route('tenant.courses.index', $institute));
});

Breadcrumbs::for('course-create', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('course', $institute);
    $breadcrumbs->push('Crear', route('tenant.classrooms.create', $institute));
});

Breadcrumbs::for('course-edit', function ($breadcrumbs, Institute $institute, Course $course) {
    $breadcrumbs->parent('course', $institute);
    $breadcrumbs->push($course->name, route('tenant.classrooms.edit', [
        'institute' => $institute,
        'course' => $course
    ]));
});

// Type Courses
Breadcrumbs::for('typecourse', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('dashboard', $institute);
    $breadcrumbs->push('Tipos de cursos', route('tenant.typecourses.index', $institute));
});

Breadcrumbs::for('typecourse-create', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('typecourse', $institute);
    $breadcrumbs->push('Crear', route('tenant.typecourses.create', $institute));
});

Breadcrumbs::for('typecourse-edit', function ($breadcrumbs, Institute $institute, TypeCourse $typeCourse) {
    $breadcrumbs->parent('typecourse', $institute);
    $breadcrumbs->push($typeCourse->name, route('tenant.typecourses.edit', [
        'institute' => $institute,
        'typeCourse' => $typeCourse
    ]));
});

// Resoruce
Breadcrumbs::for('resource', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('dashboard', $institute);
    $breadcrumbs->push('Recursos', route('tenant.resources.index', $institute));
});

Breadcrumbs::for('resource-create', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('resource', $institute);
    $breadcrumbs->push('Crear', route('tenant.resources.create', $institute));
});

Breadcrumbs::for('resource-edit', function ($breadcrumbs, Institute $institute, Resource $resource) {
    $breadcrumbs->parent('resource', $institute);
    $breadcrumbs->push($resource->name, route('tenant.resources.edit', [
        'institute' => $institute,
        'resources' => $resource
    ]));
});

// Teacher
Breadcrumbs::for('teacher', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('dashboard', $institute);
    $breadcrumbs->push('Profesor', route('tenant.teachers.index', $institute));
});

Breadcrumbs::for('teacher-create', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('teacher', $institute);
    $breadcrumbs->push('Crear', route('tenant.teachers.create', $institute));
});

Breadcrumbs::for('teacher-edit', function ($breadcrumbs, Institute $institute, Teacher $teacher) {
    $breadcrumbs->parent('teacher', $institute);
    $breadcrumbs->push($teacher->name, route('tenant.teachers.edit', [
        'institute' => $institute,
        'teachers' => $teacher
    ]));
});

// Promotion
Breadcrumbs::for('promotion', function ($breadcrumbs, Institute $institute) {
    $breadcrumbs->parent('dashboard', $institute);
    $breadcrumbs->push('Promociones', route('tenant.promotions.index', $institute));
});
