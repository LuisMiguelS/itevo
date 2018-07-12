<?php

use App\{
    Classroom, Course, BranchOffice, Resource, Teacher, TypeCourse
};

Breadcrumbs::for('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::for('dashboard', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Dashboard', route('tenant.dashboard', $branchOffice));
});

// Classroom
Breadcrumbs::for('classroom', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Aulas', route('tenant.classrooms.index', $branchOffice));
});

Breadcrumbs::for('classroom-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('classroom', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.classrooms.create', $branchOffice));
});

Breadcrumbs::for('classroom-edit', function ($breadcrumbs, BranchOffice $branchOffice, Classroom $classroom) {
    $breadcrumbs->parent('classroom', $branchOffice);
    $breadcrumbs->push($classroom->name, $classroom->url->edit);
});

// Courses
Breadcrumbs::for('course', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Cursos', route('tenant.courses.index', $branchOffice));
});

Breadcrumbs::for('course-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('course', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.classrooms.create', $branchOffice));
});

Breadcrumbs::for('course-edit', function ($breadcrumbs, BranchOffice $branchOffice, Course $course) {
    $breadcrumbs->parent('course', $branchOffice);
    $breadcrumbs->push($course->name, $course->url->edit);
});

// Type Courses
Breadcrumbs::for('typeCourse', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Tipos de cursos', route('tenant.typeCourses.index', $branchOffice));
});

Breadcrumbs::for('typeCourse-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('typeCourse', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.typeCourses.create', $branchOffice));
});

Breadcrumbs::for('typeCourse-edit', function ($breadcrumbs, BranchOffice $branchOffice, TypeCourse $typeCourse) {
    $breadcrumbs->parent('typeCourse', $branchOffice);
    $breadcrumbs->push($typeCourse->name, $typeCourse->url->edit);
});

// Resoruce
Breadcrumbs::for('resource', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Recursos', route('tenant.resources.index', $branchOffice));
});

Breadcrumbs::for('resource-create', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('resource', $branchOffice);
    $breadcrumbs->push('Crear', route('tenant.resources.create', $branchOffice));
});

Breadcrumbs::for('resource-edit', function ($breadcrumbs, BranchOffice $branchOffice, Resource $resource) {
    $breadcrumbs->parent('resource', $branchOffice);
    $breadcrumbs->push($resource->name, $resource->url->edit);
});

// Teacher
Breadcrumbs::for('teacher', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Profesor', route('tenant.teachers.index', $branchOffice));
});

Breadcrumbs::for('teacher-create', function ($breadcrumbs, BranchOffice $institute) {
    $breadcrumbs->parent('teacher', $institute);
    $breadcrumbs->push('Crear', route('tenant.teachers.create', $institute));
});

Breadcrumbs::for('teacher-edit', function ($breadcrumbs, BranchOffice $branchOffice, Teacher $teacher) {
    $breadcrumbs->parent('teacher', $branchOffice);
    $breadcrumbs->push($teacher->name, $teacher->url->edit);
});

// Promotion
Breadcrumbs::for('promotion', function ($breadcrumbs, BranchOffice $branchOffice) {
    $breadcrumbs->parent('dashboard', $branchOffice);
    $breadcrumbs->push('Promociones', route('tenant.promotions.index', $branchOffice));
});