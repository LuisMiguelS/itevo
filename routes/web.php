<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::resource('branch/offices', 'BranchOfficeController')->names([
    'index' => 'branchOffices.index',
    'show' => 'branchOffices.show',
    'create' => 'branchOffices.create',
    'store' => 'branchOffices.store',
    'edit' => 'branchOffices.edit',
    'update' => 'branchOffices.update',
    'destroy' => 'branchOffices.destroy',
])->parameters([
    'offices' => 'branchOffice'
]);

Route::resource('users', 'UserController');
Route::resource('abilities', 'AbilitieController')->only('index');
Route::resource('roles', 'RoleController');


Route::prefix('{branchOffice}')->middleware('tenantAccess')->name('tenant.')->group(function () {
    Route::get('dashboard', 'BranchOfficeController@dashboard')->name('dashboard');

    /*
     * Classrooms
     */
    Route::get('classrooms/trash', 'Tenant\ClassRoomController@trashed')->name('classrooms.trash');
    Route::delete('classrooms/{id}', 'Tenant\ClassRoomController@destroy')->name('classrooms.destroy');
    Route::delete('classrooms/{classroom}/trash', 'Tenant\ClassRoomController@trash')->name('classrooms.trash.destroy');
    Route::delete('classrooms/{id}/restore', 'Tenant\ClassRoomController@restore')->name('classrooms.trash.restore');
    Route::resource('classrooms', 'Tenant\ClassRoomController')->except('destroy');

    /*
     * Type Course
     */
    Route::get('types/courses/trash', 'Tenant\TypeCourseController@trashed')->name('typeCourses.trash');
    Route::delete('types/courses/{id}', 'Tenant\TypeCourseController@destroy')->name('typeCourses.destroy');
    Route::delete('types/courses/{typeCourse}/trash', 'Tenant\TypeCourseController@trash')->name('typeCourses.trash.destroy');
    Route::delete('types/courses/{id}/restore', 'Tenant\TypeCourseController@restore')->name('typeCourses.trash.restore');
    Route::resource('types/courses', 'Tenant\TypeCourseController')->names([
        'index' => 'typeCourses.index',
        'show' => 'typeCourses.show',
        'create' => 'typeCourses.create',
        'store' => 'typeCourses.store',
        'edit' => 'typeCourses.edit',
        'update' => 'typeCourses.update',
    ])->parameters([
        'courses' => 'typeCourse'
    ])->except('destroy');

    /*
     * Course
     */
    Route::get('courses/trash', 'Tenant\CourseController@trashed')->name('courses.trash');
    Route::delete('courses/{id}', 'Tenant\CourseController@destroy')->name('courses.destroy');
    Route::delete('courses/{course}/trash', 'Tenant\CourseController@trash')->name('courses.trash.destroy');
    Route::delete('courses/{id}/restore', 'Tenant\CourseController@restore')->name('courses.trash.restore');
    Route::resource('courses', 'Tenant\CourseController')->except('destroy');

    Route::resource('resources', 'Tenant\ResourceController');
    Route::get('promotions/{promotion}/finish', 'Tenant\PromotionController@finish')->name('promotions.finish');
    Route::resource('promotions', 'Tenant\PromotionController');
    Route::resource('promotions.periods', 'Tenant\PeriodController')->except('show', 'destroy');
    Route::resource('periods.course-period', 'Tenant\CoursePeriodController')->parameters([
        'course-period' => 'coursePeriod'
    ]);

    /*
     * Teacher
     */
    Route::get('teachers/trash', 'Tenant\TeacherController@trashed')->name('teachers.trash');
    Route::delete('teachers/{id}', 'Tenant\TeacherController@destroy')->name('teachers.destroy');
    Route::delete('teachers/{teacher}/trash', 'Tenant\TeacherController@trash')->name('teachers.trash.destroy');
    Route::delete('teachers/{id}/restore', 'Tenant\TeacherController@restore')->name('teachers.trash.restore');
    Route::resource('teachers', 'Tenant\TeacherController')->except('destroy');

    Route::resource('students', 'Tenant\StudentController');

});


