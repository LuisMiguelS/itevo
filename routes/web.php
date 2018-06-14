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

Route::get('{institute}/dashboard', function (App\Institute $institute) {
    $user = App\User::find(1);
    return dd(Bouncer::is($user)->an('others'));
})->fallback();
