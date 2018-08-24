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

    /*
     * Resources
     */
    Route::get('resources/trash', 'Tenant\ResourceController@trashed')->name('resources.trash');
    Route::delete('resources/{id}', 'Tenant\ResourceController@destroy')->name('resources.destroy');
    Route::delete('resources/{resource}/trash', 'Tenant\ResourceController@trash')->name('resources.trash.destroy');
    Route::delete('resources/{id}/restore', 'Tenant\ResourceController@restore')->name('resources.trash.restore');
    Route::resource('resources', 'Tenant\ResourceController')->except('destroy');

    /*
     * Promotion
     */
    Route::get('promotions/trash', 'Tenant\PromotionController@trashed')->name('promotions.trash');
    Route::delete('promotions/{id}', 'Tenant\PromotionController@destroy')->name('promotions.destroy');
    Route::delete('promotions/{promotion}/trash', 'Tenant\PromotionController@trash')->name('promotions.trash.destroy');
    Route::delete('promotions/{id}/restore', 'Tenant\PromotionController@restore')->name('promotions.trash.restore');
    Route::get('promotions/{promotion}/finish', 'Tenant\PromotionController@finish')->name('promotions.finish');
    Route::resource('promotions', 'Tenant\PromotionController')->except('destroy');

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

    /*
     * Student
     */
    Route::get('students/trash', 'Tenant\StudentController@trashed')->name('students.trash');
    Route::delete('students/{id}', 'Tenant\StudentController@destroy')->name('students.destroy');
    Route::delete('students/{student}/trash', 'Tenant\StudentController@trash')->name('students.trash.destroy');
    Route::delete('students/{id}/restore', 'Tenant\StudentController@restore')->name('students.trash.restore');
    Route::resource('students', 'Tenant\StudentController')->except('destroy');

   /*
    * Schedules
    */
    Route::get('schedules/trash', 'Tenant\ScheduleController@trashed')->name('schedules.trash');
    Route::delete('schedules/{id}', 'Tenant\ScheduleController@destroy')->name('schedules.destroy');
    Route::delete('schedules/{schedule}/trash', 'Tenant\ScheduleController@trash')->name('schedules.trash.destroy');
    Route::delete('schedules/{id}/restore', 'Tenant\ScheduleController@restore')->name('schedules.trash.restore');
    Route::resource('schedules', 'Tenant\ScheduleController')->except('destroy');

});


