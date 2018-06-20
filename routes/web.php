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
Route::resource('classrooms', 'ClassRoomController');
Route::resource('courses', 'CourseController');
Route::resource('resources', 'ResourceController');
Route::resource('types/courses', 'TypeCourseController')->names([
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

Route::resource('users', 'UserManagement\UserController');
Route::resource('abilities', 'UserManagement\AbilitieController');
Route::resource('roles', 'UserManagement\RoleController');

Route::prefix('{institute}')->name('admin.')->group(function () {
    Route::get('dashboard', 'InstituteController@dashboard')->name('dashboard');
    Route::resource('classrooms', 'ClassRoomController');
});


