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
    Route::resource('classrooms', 'Tenant\ClassRoomController');
    Route::resource('types/courses', 'Tenant\TypeCourseController')->names([
        'index' => 'typeCourses.index',
        'show' => 'typeCourses.show',
        'create' => 'typeCourses.create',
        'store' => 'typeCourses.store',
        'edit' => 'typeCourses.edit',
        'update' => 'typeCourses.update',
        'destroy' => 'typeCourses.destroy',
    ])->parameters([
        'courses' => 'typeCourse'
    ]);
    Route::resource('courses', 'Tenant\CourseController');
    Route::resource('resources', 'Tenant\ResourceController');
    Route::post('promotions/{promotion}/status/change', 'Tenant\PromotionController@changeStatus')->name('promotions.status');
    Route::resource('promotions', 'Tenant\PromotionController');
    Route::resource('teachers', 'Tenant\TeacherController');
    Route::resource('students', 'Tenant\StudentController');

});


