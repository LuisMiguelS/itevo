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

Route::get('{institute}/dashboard', 'InstituteController@dashboard')->name('institutes.dashboard')->fallback();
