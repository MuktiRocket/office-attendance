<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Web\HomeController@index')->name('home');

Auth::routes();

Route::get('home', 'Web\HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'employee'], function () {
        Route::get('list', 'Web\EmployeeController@list')->name('employee_list');
        Route::get('create', 'Web\EmployeeController@createEmployeeView')->name('employee_create_view');
        Route::get('search_company', 'Web\EmployeeController@searchCompany')->name('search_company');
        Route::post('search_employee', 'Web\EmployeeController@searchEmployee')->name('search_employee_according_designation');
        Route::post('create', 'Web\EmployeeController@createEmployee')->name('employee_create');
        Route::get('deactivate/{id}', 'Web\EmployeeController@deactivate')->name('employee_deactivate');
        Route::get('reactivate/{id}', 'Web\EmployeeController@reactivate')->name('employee_reactivate');
        Route::get('delete/{id}', 'Web\EmployeeController@delete')->name('employee_delete');
        Route::get('edit/{id}', 'Web\EmployeeController@editView');
        Route::post('edit', 'Web\EmployeeController@edit')->name('employee_edit');
    });
    Route::group(['prefix' => 'employee_attendance'], function () {
        Route::get('attendance', 'Web\EmployeeAttendanceController@attendance')->name('attendance_list');
        Route::get('category', 'Web\EmployeeAttendanceController@attendanceCategory')->name('attendance_category_list');
        Route::get('create/category', 'Web\EmployeeAttendanceController@createAttendanceCategoryView')->name('category_create_view');
        Route::post('create/category', 'Web\EmployeeAttendanceController@createAttendanceCategory')->name('create_category');
        Route::post('attendance', 'Web\EmployeeAttendanceController@list')->name('employee_attendance_list');
        Route::get('save/{id}', 'Web\EmployeeAttendanceController@downloadImage')->name('attendance.download');
    });
    Route::group(['prefix' => 'company'], function () {
        Route::get('list', 'Web\CompanyController@list')->name('company_list');
        Route::get('create', 'Web\CompanyController@createCompanyView')->name('company_create_view');
        Route::post('create', 'Web\CompanyController@create')->name('create_company');
    });
    Route::group(['prefix' => 'designation'], function () {
        Route::get('list', 'Web\DesignationController@list')->name('designation_list');
        Route::get('create', 'Web\DesignationController@createDesignationView')->name('designation_create_view');
        Route::post('create', 'Web\DesignationController@create')->name('create_designation');
    });
    Route::group(['prefix' => 'report'], function () {
        Route::get('attendance_report', 'Web\ReportController@attendanceReportView')->name('get_attendance_report');
        Route::post('attendance_report', 'Web\ReportController@attendanceReportExport')->name('export_attendance_report');
    });
    Route::group(['prefix' => 'branch'], function () {
        Route::get('list', 'Web\BranchController@list')->name('branch_list');
        Route::get('create', 'Web\BranchController@createBranchView')->name('branch_create_view');
        Route::post('create', 'Web\BranchController@create')->name('create_branch');
        Route::get('edit/{id}', 'Web\BranchController@editView');
        Route::post('edit', 'Web\BranchController@edit')->name('branch_edit');
    });
});
