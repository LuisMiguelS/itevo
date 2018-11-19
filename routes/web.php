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

use App\Http\Controllers\{BranchOfficeController,
    SettingBranchOfficeController,
    Tenant\ClassRoomController,
    Tenant\CourseController,
    Tenant\TypeCourseController};

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::redirect('/', '/home', 301);

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
])->except('show');

Route::resource('users', 'UserController')->except('show');
Route::resource('abilities', 'AbilitieController')->only('index');
Route::resource('roles', 'RoleController')->except('show');


Route::prefix('{branchOffice}')->middleware(['auth', 'tenantAccess'])->name('tenant.')->group(function () {

    Route::get('dashboard', [BranchOfficeController::class, 'dashboard'])->name('dashboard');

    Route::get('settings', [SettingBranchOfficeController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingBranchOfficeController::class, 'settings'])->name('settings.store');

    /*
     * Classrooms
     */
    Route::get('classrooms/trash', [ClassRoomController::class, 'trashed'])->name('classrooms.trash');
    Route::delete('classrooms/{id}', [ClassRoomController::class, 'destroy'])->name('classrooms.destroy');
    Route::delete('classrooms/{classroom}/trash', [ClassRoomController::class, 'trash'])->name('classrooms.trash.destroy');
    Route::delete('classrooms/{id}/restore', [ClassRoomController::class, 'restore'])->name('classrooms.trash.restore');
    Route::resource('classrooms', 'Tenant\ClassRoomController')->except('destroy', 'show');

    /*
     * Type Course
     */
    Route::get('types/courses/trash', [TypeCourseController::class, 'trashed'])->name('typeCourses.trash');
    Route::delete('types/courses/{id}', [TypeCourseController::class, 'destroy'])->name('typeCourses.destroy');
    Route::delete('types/courses/{typeCourse}/trash', [TypeCourseController::class, 'trash'])->name('typeCourses.trash.destroy');
    Route::delete('types/courses/{id}/restore', [TypeCourseController::class, 'restore'])->name('typeCourses.trash.restore');
    Route::resource('types/courses', 'Tenant\TypeCourseController')->names([
        'index' => 'typeCourses.index',
        'show' => 'typeCourses.show',
        'create' => 'typeCourses.create',
        'store' => 'typeCourses.store',
        'edit' => 'typeCourses.edit',
        'update' => 'typeCourses.update',
    ])->parameters([
        'courses' => 'typeCourse'
    ])->except('destroy', 'show');

    /*
     * Course
     */
    Route::get('courses/trash', [CourseController::class, 'trashed'])->name('courses.trash');
    Route::delete('courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::delete('courses/{course}/trash', [CourseController::class, 'trash'])->name('courses.trash.destroy');
    Route::delete('courses/{id}/restore', [CourseController::class, 'restore'])->name('courses.trash.restore');
    Route::resource('courses', 'Tenant\CourseController')->except('destroy', 'show');

    /*
     * Resources
     */
    Route::get('resources/trash', 'Tenant\ResourceController@trashed')->name('resources.trash');
    Route::delete('resources/{id}', 'Tenant\ResourceController@destroy')->name('resources.destroy');
    Route::delete('resources/{resource}/trash', 'Tenant\ResourceController@trash')->name('resources.trash.destroy');
    Route::delete('resources/{id}/restore', 'Tenant\ResourceController@restore')->name('resources.trash.restore');
    Route::resource('resources', 'Tenant\ResourceController')->except('destroy', 'show');

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

    /*
     * Course-Period
     */
    Route::get('courses/record', 'Tenant\CourseRecordController@index')->name('courses.record');
    Route::get('periods/{period}/course-period/{coursePeriod}/resources', 'Tenant\CoursePeriodController@resource')
        ->name('periods.course-period.resources.index');
    Route::post('periods/{period}/course-period/{coursePeriod}/resources', 'Tenant\CoursePeriodController@addResource')
        ->name('periods.course-period.resources');

    Route::get('periods/{period}/course-period/{coursePeriod}/schedules', 'Tenant\CoursePeriodController@schedule')
        ->name('periods.course-period.schedules.index');
    Route::get('periods/{period}/course-period/schedules/show', 'Tenant\CoursePeriodController@show')
        ->name('periods.course-period.schedules.show');
    Route::post('periods/{period}/course-period/{coursePeriod}/schedules', 'Tenant\CoursePeriodController@addSchedule')
        ->name('periods.course-period.schedules');
    Route::resource('periods.course-period', 'Tenant\CoursePeriodController')->parameters([
        'course-period' => 'coursePeriod'
    ])->except('show');

    /*
     * Teacher
     */
    Route::get('teachers/trash', 'Tenant\TeacherController@trashed')->name('teachers.trash');
    Route::delete('teachers/{id}', 'Tenant\TeacherController@destroy')->name('teachers.destroy');
    Route::delete('teachers/{teacher}/trash', 'Tenant\TeacherController@trash')->name('teachers.trash.destroy');
    Route::delete('teachers/{id}/restore', 'Tenant\TeacherController@restore')->name('teachers.trash.restore');
    Route::resource('teachers', 'Tenant\TeacherController')->except('destroy', 'show');

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
    Route::resource('schedules', 'Tenant\ScheduleController')->except('destroy', 'show');

    /*
     * Inscription
     */
    Route::get('inscriptiones','Tenant\InscriptionController@index')->name('inscription.index');
    Route::post('inscriptiones','Tenant\InscriptionController@store')->name('inscription.store');
    Route::get('inscription/students','Tenant\InscriptionController@students')->name('inscription.students');
    Route::get('inscription/courses','Tenant\InscriptionController@courses')->name('inscription.courses');

    /*
     * Invoice
     */
    Route::get('invoices', 'Tenant\InvoiceController@index')->name('invoice.index');
    Route::get('invoices/{invoice}', 'Tenant\InvoiceController@show')->name('invoice.show');
    Route::get('invoices/accounts/receivable/{id}', 'Tenant\InvoiceController@accountReceivable')->name('invoice.accounts_receivable');

    /*
     * Accounts Receivable
     */
    Route::get('accounts/receivable', 'Tenant\AccountsReceivableController@index')->name('accounts_receivable.index');
    Route::post('accounts/receivable', 'Tenant\AccountsReceivableController@store')->name('accounts_receivable.store');
    Route::get('accounts/receivable/students', 'Tenant\AccountsReceivableController@students')->name('accounts_receivable.students');
    Route::get('accounts/receivable/invoices/{invoice}', 'Tenant\AccountsReceivableController@breakdownPendingPayment')->name('accounts_receivable.breakdown_pending_payment');

    /*
     *  Balance Day
     */
    Route::get('balance/day', 'Tenant\BalanceDayController@index')->name('balance_day.index');
});


