<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@userLogin');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/logout', 'API\UserController@userLogout');
    Route::group(['prefix' => 'attendance'], function () {
        Route::get('today', 'API\AttendanceController@employeeAttendanceToday');
        Route::get('category', 'API\AttendanceController@attendanceCategory');
        Route::post('employee/in_out', 'API\AttendanceController@employeeDailyAttendance');
        Route::post('location', 'API\AttendanceController@getLatLong');
    });
});
