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

Route::resource('institutes', 'InstituteController');
Route::resource('users', 'UserController');
Route::resource('abilities', 'AbilitieController')->only('index');
Route::resource('roles', 'RoleController');


Route::prefix('{institute}')->middleware('tenantAccess')->name('tenant.')->group(function () {
    Route::get('dashboard', 'InstituteController@dashboard')->name('dashboard');
    Route::resource('classrooms', 'Tenant\ClassRoomController');
    Route::resource('types/courses', 'Tenant\TypeCourseController')->names([
        'index' => 'typecourses.index',
        'show' => 'typecourses.show',
        'create' => 'typecourses.create',
        'store' => 'typecourses.store',
        'edit' => 'typecourses.edit',
        'update' => 'typecourses.update',
        'destroy' => 'typecourses.destroy',
    ])->parameters([
        'courses' => 'typeCourse'
    ]);
    Route::resource('courses', 'Tenant\CourseController');
    Route::resource('resources', 'Tenant\ResourceController');
    Route::resource('promotions', 'Tenant\PromotionController')->only('index');
});


