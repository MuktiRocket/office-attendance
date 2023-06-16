<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\LatLongHistoryRequest;
use App\Http\Requests\Employee\UpdateLocationRequest;
use App\Http\Requests\User\EmployeeAttendanceRequest;
use App\Http\Resources\Attendance\AttendanceCategoryResource;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Models\AttendanceCategory;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeLatLongHistory;
use App\Service\User\UsersServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttendanceController extends BaseController
{
    /**
     * @var UsersServices
     */
    private $usersServices;

    public function __construct(UsersServices $usersServices)
    {

        $this->usersServices = $usersServices;
    }

    //Provide all the attendance categories from attendance_categories table
    public function attendanceCategory(Request $request)
    {
        $user = $request->user();
        $categoryList = AttendanceCategory::where('company_id', $user->company_id)->orderBy('id')->get();
        if (count($categoryList)) {
            $data = [
                'category_list' => AttendanceCategoryResource::collection($categoryList)
            ];
            return $this->respond(trans('http.success'), Response::HTTP_OK, $data);
        }
        return $this->respond('No Attendance Categories Found', Response::HTTP_NOT_FOUND);
    }

    //Track users lat long and store in database
    public function getLatLong(LatLongHistoryRequest $request)
    {
        $user = $request->user();
        $current_date  = date('Y-m-d');
        $already_attendance_done = EmployeeAttendance::where('user_id', $user->id)->whereDate('created_at', $current_date)->first();
        if (!$already_attendance_done) {
            return $this->respond('Please provide attendance first', Response::HTTP_FORBIDDEN);
        } else if ($already_attendance_done->attendance_given == 'SIGNED OUT') {
            return $this->respond('User already signed out for the day', Response::HTTP_FORBIDDEN);
        }
        EmployeeLatLongHistory::create([
            'attendance_id' => $already_attendance_done->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return $this->respond('Latitude and longitude recorded successfully.', Response::HTTP_OK);
    }

    //Employee attendance
    public function employeeDailyAttendance(EmployeeAttendanceRequest $request)
    {
        $user = $request->user();
        $current_date  =   date('Y-m-d');
        $get_attendance =   EmployeeAttendance::where('user_id', $user->id)->whereDate('created_at', $current_date)->first();
        if (!empty($get_attendance) && $get_attendance->attendance_given == 'SIGNED OUT') {
            return $this->respond('User already signed out for the day', Response::HTTP_FORBIDDEN);
        }
        $attendance = $this->usersServices->makeInAndOutAttendance($request, $user);
        return $this->respond(trans('auth.attendance_done'), Response::HTTP_CREATED, ['attendance' => new AttendanceResource($attendance)]);
    }

    //Check for attendance status from dashboard
    public function employeeAttendanceToday(Request $request)
    {
        $user = $request->user();
        $current_date  = date('Y-m-d');
        $already_attendance_done = EmployeeAttendance::where('user_id', $user->id)->whereDate('created_at', $current_date)->first();
        if (!$already_attendance_done) {
            $data['attendance_for_day'] = false;
        } else if ($already_attendance_done->attendance_given == 'SIGNED IN') {
            $data['attendance_for_day'] = false;
        } else {
            $data['attendance_for_day'] = true;
        }
        return $this->respond('Attendance for the day is done', Response::HTTP_OK, $data);
    }
}
